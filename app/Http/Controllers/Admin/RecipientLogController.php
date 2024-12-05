<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Person;
use App\Models\Recipient;
use App\Models\RecipientLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RecipientLogController extends Controller
{
    public function index()
    {
        $userInfo = Person::where('identification_number', Auth::user()->username)->first();

        $recipientQuery = RecipientLog::query()
            ->with(['recipient.person', 'recipient.detailAssistance.assistance']) // Eager loading relasi
            ->latest(); // Urutkan berdasarkan data terbaru


        if (Auth::user()->roles->first()->id == 2) {
            // Jika user role adalah 2, filter berdasarkan identification_number
            $recipientQuery->whereHas('recipient.person', function ($query) use ($userInfo) {
                $query->where('identification_number', $userInfo->identification_number);
            });
        }

        // Eksekusi query dan dapatkan hasilnya
        $recipients = $recipientQuery->get();

        $assistances = Assistance::latest()->get();

        if (request()->ajax()) {
            return DataTables::of($recipients)
                ->addIndexColumn()
                ->addColumn('person', function ($row) {
                    return $row->recipient->person ? $row->recipient->person->name : '-';
                })
                ->addColumn('assistance', function ($row) {
                    return $row->recipient->detailAssistance ? $row->recipient->detailAssistance->assistance->name : '-';
                })
                ->addColumn('period', function ($row) {
                    return Carbon::parse($row->log_date)->translatedFormat('F Y');
                })
                ->addColumn('status', function ($row) {
                    return $row->status();
                })
                ->addColumn('action', 'admin.recipient.include.action')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.recipient.log', compact('assistances'));
    }

    public function export(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $assistance_id = $request->assistance_id;

        $fmt = new \IntlDateFormatter('id_ID', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, null, null, 'MMMM');
        $date = DateTime::createFromFormat('!m', $month);
        $month_name = $fmt->format($date);

        $assistance = Assistance::find($assistance_id);
        $assistance_name = $assistance->name;

        $logs = RecipientLog::whereMonth('log_date', $month)
            ->whereYear('log_date', $year)
            ->whereHas('recipient.detailAssistance.assistance', function ($query) use ($assistance_id) {
                $query->where('id', $assistance_id);
            })
            ->with('recipient.detailAssistance.assistance')
            ->get();

        $pdf = Pdf::loadView('admin.recipient.report.log', compact('assistance_name', 'month_name', 'logs', 'year'))
            ->setPaper('A3', 'landscape');

        if ($assistance_id && $month && $year) {
            return $pdf->stream('DAFTAR PENERIMA' . strtoupper($assistance_name) . '.pdf');
        } else {
            return redirect()->back()->with('toast_error', 'Maaf, tidak bisa export data');
        }
    }
}
