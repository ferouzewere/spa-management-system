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
        // Handle GET request: Display the booking form
        $services = Service::all(); // Fetch all available services
        return view('bookings.create', compact('services'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_time' => 'required|date',
        ]);

        // Automatically assign an employee (example: first available employee)
        $employee = Employee::where('is_available', true)->first();

        // Save the booking to the database
        $booking = Booking::create([
            'service_id' => $validated['service_id'],
            'appointment_time' => $validated['appointment_time'],
            'employee_id' => $employee->id ?? null,
            'customer_id' => Auth::user()->id, // Assign the currently authenticated user as the customer
        ]);

        // Redirect to the dashboard view with a success message
        return redirect()->route('client.dashboard')->with([
            'success' => 'Your booking has been successfully created!',
            'booking' => $booking, // Pass the booking details to the session
        ]);
    }

    public function index()
    {
        // Fetch the latest booking for the authenticated user
        $booking = Booking::latest()->first(); // Adjust this logic as needed
        return view('bookings.index', compact('booking'));
    }
}
