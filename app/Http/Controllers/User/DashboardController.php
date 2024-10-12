<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        return view('user.index', compact('profile'));
    }

    public function search()
    {
        return view('user.search');
    }
}
