<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Person;
use App\Models\Profile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $asisstances = Assistance::all();

        return view('user.index', compact('profile', 'asisstances'));
    }

    public function search(Request $request)
    {
        $profile = Profile::first();
        $name = $request->input('name');
        $assistanceId = $request->input('assistance_id');

        $results = Person::query();

        if ($name) {
            $results->where('name', 'LIKE', '%' . $name . '%');
        }

        if ($assistanceId) {
            $results->whereHas('recipients', function ($query) use ($assistanceId) {
                $query->where('assistance_id', $assistanceId);
            });
        }

        $results = $results->get();

        // dd($results);

        return view('user.search', compact('profile', 'results'));
    }
}
