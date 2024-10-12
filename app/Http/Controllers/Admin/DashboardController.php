<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Person;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMale = Person::where('gender', 1)->count();
        $totalFemale = Person::where('gender', 2)->count();
        $totalPerson = Person::count();
        $assistanceCounts = Assistance::withCount('recipient')->get();

        return view('admin.dashboard.index', compact('totalMale', 'totalFemale', 'totalPerson', 'assistanceCounts'));
    }
}
