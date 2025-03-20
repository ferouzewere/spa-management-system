<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $appointments = $user->appointments; // Assuming a relationship exists in the User model

        return view('dashboard.client', compact('appointments'));
    }
}
