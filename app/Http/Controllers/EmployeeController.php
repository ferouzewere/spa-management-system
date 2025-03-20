<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();

        $todaysAppointments = $employee->appointments()
            ->whereDate('date', now()->toDateString())
            ->orderBy('time')
            ->get();

        $clientRequests = []; // Assuming you will fetch client requests here

        return view('dashboard.employee', [
            'todaysAppointments' => $todaysAppointments,
            'work_schedule' => $employee->work_schedule,
            'clientRequests' => $clientRequests,
            'employee' => $employee,
        ]);
    }

    public function updateAvailability(Request $request)
    {
        $validated = $request->validate([
            'availability' => 'required|string|in:available,busy,off-duty',
        ]);

        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        $employee->availability = $validated['availability'];
        $employee->save();

        return back()->with('status', 'Availability updated successfully.');
    }

    public function manageAppointments()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        $appointments = $employee->appointments; // Assuming a relationship exists

        return view('appointments.manage', compact('appointments'));
    }
}
