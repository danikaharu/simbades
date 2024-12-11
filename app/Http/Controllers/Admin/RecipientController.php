<?php

namespace App\Http\Controllers\Admin;

use App\Events\QrCodeScanned;
use App\Exports\RecipientExport;
use App\Http\Controllers\Controller;
use App\Models\Recipient;
use App\Http\Requests\StoreRecipientRequest;
use App\Http\Requests\UpdateRecipientRequest;
use App\Models\Assistance;
use App\Models\Person;
use App\Models\Profile;
use Carbon\Carbon;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class RecipientController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view recipient'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create recipient'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete recipient'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('export recipient'), only: ['export']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('barcode recipient'), only: ['showBarcodePage']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('verification recipient'), only: ['showScanPage', 'verificationQrCode']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('reset status recipient'), only: ['reset']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userInfo = Person::where('identification_number', Auth::user()->username)->first();

        $recipientQUery = Recipient::query();

        if (Auth::user()->roles->first()->id == 2) {
            $recipients =  Recipient::with('person')
                ->whereHas('person', function ($query) use ($userInfo) {
                    $query->where('identification_number', $userInfo->identification_number);
                })->latest()->get();
        } else {
            $recipients = $recipientQUery->with('person')->latest()->get();
        }

        if (request()->ajax()) {
            return DataTables::of($recipients)
                ->addIndexColumn()
                ->addColumn('person', function ($row) {
                    return $row->person ? $row->person->name : '-';
                })
                ->addColumn('address', function ($row) {
                    return $row->person ? $row->person->village->name : '-';
                })
                ->addColumn('assistance', function ($row) {
                    return $row->assistance ? $row->assistance->name : '-';
                })
                ->addColumn('action', 'admin.recipient.include.action')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.recipient.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $persons = Person::latest()->get();
        $assistances = Assistance::latest()->get();
        return view('admin.recipient.create', compact('persons', 'assistances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipientRequest $request)
    {
        try {
            $attr = $request->validated();

            Recipient::create($attr);

            return redirect()->route('admin.recipient.index')->with('success', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            return redirect()->route('admin.recipient.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipient $recipient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipient $recipient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipientRequest $request, Recipient $recipient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipient $recipient)
    {
        try {

            $recipient->delete();

            return redirect()
                ->route('admin.recipient.index')
                ->with('success', __('Data Berhasil Dihapus'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.recipient.index')
                ->with('error', __($th->getMessage()));
        }
    }

    public function showBarcodePage(Recipient $recipient)
    {
        $expiration = Carbon::now()->addMinute(5);

        $qrData = json_encode([
            'id penerima' => $recipient->id,
            'nama' => $recipient->person->name,
            'bantuan' => $recipient->assistance->name,
            'waktu kadaluarsa' => $expiration->toDateTimeString()
        ]);

        $recipient->qr_data = $qrData;
        $recipient->save();

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrData)
            ->encoding(new Encoding('UTF-8'))
            ->size(300)
            ->margin(10)
            ->build();

        $qrCode = $result->getDataUri();

        return view('admin.recipient.barcode', compact('recipient', 'qrCode', 'expiration'));
    }

    public function showScanPage()
    {
        return view('admin.recipient.scan');
    }

    public function verificationQrCode(Request $request)
    {
        // Validasi data input
        $attr = $request->validate([
            'code' => 'required|string',
        ]);

        // Cari recipient berdasarkan kode
        $recipient = Recipient::where('qr_data', $attr['code'])->first();

        if (!$recipient) {
            return response()->json(['status' => 'error', 'message' => 'QR Code tidak ditemukan.'], 404);
        }

        // Decode data QR code untuk memeriksa waktu kadaluwarsa
        $qrData = json_decode($recipient->qr_data, true);
        $expirationTime = Carbon::parse($qrData['waktu kadaluarsa']);

        // Cek kadaluarsa
        if (Carbon::now()->greaterThan($expirationTime)) {
            return response()->json(['status' => 'error', 'message' => 'QR Code sudah kadaluarsa.'], 400);
        }

        // Update status jika QR Code valid
        $recipient->status = 1;
        $recipient->save();

        // Emit event untuk memancarkan ke klien
        event(new QrCodeScanned($request->code));

        return response()->json(['status' => 'success', 'message' => 'QR Code berhasil diverifikasi.'], 200);
    }

    public function scanned(Recipient $recipient)
    {
        return response()->json(['status' => $recipient->status]);
    }

    public function export(Request $request)
    {
        $profile = Profile::first();
        $year = $request->input('year');

        if ($year) {
            return Excel::download(new RecipientExport($year), 'Bantuan Sosial Desa ' . $profile->village_name . ' Tahun ' . $year . '.xlsx');
        } else {
            return redirect()->back()->with('error', 'Maaf, tidak bisa export data');
        }
    }

    public function reset(Recipient $recipient)
    {
        try {
            $recipient->update(
                ['status' => 0]
            );

            return redirect()
                ->route('admin.log.recipient')
                ->with('success', __('Status Berhasil di Reset'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.log.recipient')
                ->with('error', __($th->getMessage()));
        }
    }
}
