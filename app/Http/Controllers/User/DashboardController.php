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

        if (!empty($name)) {
            $results->where('name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($assistanceId)) {
            $results->whereHas('recipients.detailAssistance.assistance', function ($query) use ($assistanceId) {
                $query->where('id', $assistanceId);
            });
        }

        $results = $results->get();


        return view('user.search', compact('profile', 'results'));
    }
}
