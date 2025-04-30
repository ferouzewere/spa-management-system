<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Service;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Fetch all necessary data for the dashboard
        $appointments = Booking::where('customer_id', $user->id)
            ->orderBy('appointment_time', 'desc')
            ->get();

        $payments = Payment::where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $reviews = Review::where('customer_id', $user->id)
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->get();

        $services = Service::all();

        return view('dashboard.client', compact('appointments', 'payments', 'reviews', 'services'));
    }
}
