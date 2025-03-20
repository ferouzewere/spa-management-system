<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Employee;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.admin');
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $validated['status'];
        $booking->save();

        return back()->with('status', 'Booking status updated successfully.');
    }
}
