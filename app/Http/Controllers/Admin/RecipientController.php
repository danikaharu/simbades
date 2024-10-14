<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('barcode recipient'), only: ['download', 'refreshQrCode']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('verification recipient'), only: ['verificationQrCode']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userInfo = Person::where('identification_number', Auth::user()->username)->first();

        $recipientQUery = Recipient::query();

        if (Auth::user()->roles->first()->id == 1) {
            $recipients = $recipientQUery->with('person')->latest()->get();
        } else {
            $recipients =  Recipient::with('person')
                ->whereHas('person', function ($query) use ($userInfo) {
                    $query->where('identification_number', $userInfo->username);
                })->latest()->get();
        }

        if (request()->ajax()) {
            $recipients = Recipient::with('person')->latest()->get();
            return DataTables::of($recipients)
                ->addIndexColumn()
                ->addColumn('person', function ($row) {
                    return $row->person ? $row->person->name : '-';
                })
                ->addColumn('assistance', function ($row) {
                    return $row->assistance ? $row->assistance->name : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status();
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

    public function download(Recipient $recipient)
    {
        $expiration = Carbon::now()->addMinute(5);

        $qrData = json_encode([
            'nama' => $recipient->person->name,
            'bantuan' => $recipient->assistance->name,
            'jenis bantuan' => $recipient->assistance->type(),
            'keterangan' => $recipient->assistance->additional_data,
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

        $qrCodeDataUri = $result->getDataUri();

        return view('admin.recipient.barcode', compact('recipient', 'qrCodeDataUri', 'expiration'));
    }

    public function verificationQrCode(Request $request)
    {
        // Validasi data input
        $attr = $request->validate([
            'code' => 'required|string',
        ]);

        // Cari recipient berdasarkan kode atau sesuai dengan logika Anda
        $recipient = Recipient::where('qr_data', 'like', '%' . $attr['code'] . '%')->first();

        if ($recipient) {
            // Decode data QR code untuk memeriksa waktu kadaluwarsa
            $qrData = json_decode($recipient->qr_data, true); // Mengambil data QR
            $expirationTime = Carbon::parse($qrData['waktu kadaluarsa']); // Waktu kadaluarsa dari data QR

            // Cek kadaluarsa
            if (Carbon::now()->greaterThan($expirationTime)) {
                return response()->json(['status' => 'error', 'message' => 'QR Code sudah kadaluwarsa.'], 403);
            }

            // Cek status QR code
            if ($recipient->status == 1) {
                return response()->json(['status' => 'scanned', 'message' => 'QR Code sudah dipindai sebelumnya.']);
            }

            $recipient->status = 1;
            $recipient->save();

            return response()->json(['status' => 'success', 'message' => 'QR Code berhasil dipindai!']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'QR Code tidak ditemukan.'], 404);
        }
    }

    public function checkQrCodeStatus(Request $request)
    {
        // Cek status QR code di database
        $recipient = Recipient::where('qr_data', 'like', '%' . $request->input('code') . '%')->first();

        if ($recipient) {
            if ($recipient->status == 1) {
                return response()->json(['status' => 'scanned', 'redirect' => route('admin.recipient.index')]);
            }
        }

        return response()->json(['status' => 'not scanned']);
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
}
