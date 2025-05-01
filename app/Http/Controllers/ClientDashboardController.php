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

        return view('dashboard.client')
            ->with('appointmentsData', view('dashboard.appointments', [
                'appointments' => Booking::where('customer_id', $user->id)
                    ->orderBy('appointment_time', 'desc')
                    ->get()
            ])->render())
            ->with('paymentsData', view('dashboard.payments', [
                'payments' => Payment::where('customer_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get()
            ])->render())
            ->with('reviewsData', view('dashboard.reviews', [
                'reviews' => Review::where('customer_id', $user->id)
                    ->with('service')
                    ->orderBy('created_at', 'desc')
                    ->get(),
                'services' => Service::all()
            ])->render());
    }
}
