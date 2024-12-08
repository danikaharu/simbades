<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Information;
use App\Models\Person;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMale = Person::where('gender', 1)->count();
        $totalFemale = Person::where('gender', 2)->count();
        $totalPerson = Person::count();
        $assistanceCounts = Assistance::with('recipients') // Eager load recipients
            ->get()
            ->map(function ($assistance) {
                return [
                    'name' => $assistance->name, // Nama bantuan
                    'recipient_count' => $assistance->recipients->count(), // Jumlah penerima
                ];
            });
        $information = Information::first();

        return view('admin.dashboard.index', compact('information', 'totalMale', 'totalFemale', 'totalPerson', 'assistanceCounts'));
    }
}
