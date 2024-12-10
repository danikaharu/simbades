<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Profile;
use App\Models\Recipient;
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

        $results = Recipient::query();

        // Filter berdasarkan nama jika ada
        if (!empty($name)) {
            $results->whereHas('person', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            });
        }

        // Filter berdasarkan assistance_id jika ada
        if (!empty($assistanceId)) {
            $results->whereHas('assistance', function ($query) use ($assistanceId) {
                $query->where('id', 'LIKE', '%' . $assistanceId . '%');
            });
        }

        // Mengambil hasil query yang telah difilter
        $results = $results->get();

        return view('user.search', compact('profile', 'results', 'assistanceId'));
    }
}
