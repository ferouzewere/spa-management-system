<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Booking;

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
        ]);

        // Redirect to the bookings.index view with a success message
        return redirect()->route('bookings.index')->with('success', 'Appointment booked successfully!');
    }

    public function index()
    {
        // Fetch the latest booking for the authenticated user
        $booking = Booking::latest()->first(); // Adjust this logic as needed
        return view('bookings.index', compact('booking'));
    }
}
