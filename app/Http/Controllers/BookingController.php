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
        // Change this if errors arise in storing booked appointments.

        // Validate the request
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_time' => 'required|date',
        ]);

        // Automatically assign an employee (example: first available employee)
        $employee = Employee::where('is_available', true)->first();

        if (!$employee) {
            return back()->withErrors(['error' => 'No available employees at the moment.']);
        }

        // Create the booking
        Booking::create([
            'service_id' => $validated['service_id'],
            'employee_id' => $employee->id,
            'appointment_time' => $validated['appointment_time'],
        ]);

        return redirect()->route('bookings.index')->with('success', 'Appointment booked successfully!');
    }
}
