<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            // Handle GET request: Display the booking form
            $services = Service::all(); // Fetch all available services
            return view('bookings.create', compact('services'));
        }

        if ($request->isMethod('post')) {
            // Handle POST request: Process the booking form submission
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'date' => 'required|date|after_or_equal:today',
            ]);

            $appointment = $request->user()->appointments()->create([
                'service_id' => $validated['service_id'],
                'date' => $validated['date'],
                'status' => 'pending',
            ]);

            return redirect()->route('client.dashboard')->with('success', 'Appointment booked successfully!');
        }
    }

    public function store(Request $request)
    {
        $booking = Booking::create([
            'service_id' => $request->service_id,
            'appointment_time' => $request->appointment_time,
            'employee_id' => $request->employee_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Your booking has been successfully created!');
    }

    public function index()
    {
        // Fetch the latest booking for the authenticated user
        $booking = Booking::latest()->first(); // Adjust this logic as needed
        return view('bookings.index', compact('booking'));
    }
}
