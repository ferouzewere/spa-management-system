<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Booking;

class BookingController extends Controller
{
    public function create()
    {
        $services = Service::all(); // Fetch all services
        $employees = Employee::where('availability', true)->get(); // Fetch available employees
        return view('bookings.create', compact('services', 'employees')); // Pass data to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'service_id' => 'required|exists:services,id',
            'appointment_time' => 'required|date|after:now',
        ]);

        Booking::create([
            'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
            'employee_id' => $request->employee_id,
            'service_id' => $request->service_id,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending'
        ]);

        return redirect()->route('client.dashboard')->with('success', 'Booking Confirmed');
    }
}
