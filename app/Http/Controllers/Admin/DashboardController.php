<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Person;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMale = Person::where('gender', 1)->count();
        $totalFemale = Person::where('gender', 2)->count();
        $totalPerson = Person::count();
        $assistanceCounts = Assistance::with('detailAssistance.recipient')
            ->get()
            ->map(function ($assistance) {
                $recipientCount = $assistance->detailAssistance->sum(function ($detail) {
                    return $detail->recipient->count();
                });

                return [
                    'name' => $assistance->name,
                    'recipient_count' => $recipientCount,
                ];
            });

        return view('admin.dashboard.index', compact('totalMale', 'totalFemale', 'totalPerson', 'assistanceCounts'));
    }
}
