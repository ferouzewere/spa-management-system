<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.employee');
    }

    public function updateAvailability(Request $request)
    {
        $validated = $request->validate([
            'availability' => 'required|boolean',
        ]);

        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        $employee->availability = $validated['availability'];
        $employee->save();

        return back()->with('status', 'Availability updated successfully.');
    }
}
