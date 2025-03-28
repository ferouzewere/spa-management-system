<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // Import the Booking model

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Fetch bookings instead of appointments
        $appointments = Booking::where('customer_id', $user->id)->get();

        return view('dashboard.client', compact('appointments'));
    }
}
