<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::with('role')->get();
        $roles = Role::all();
        $services = \App\Models\Service::all();
        $bookings = Booking::with(['service', 'customer', 'employee.user'])->orderBy('appointment_time', 'desc')->get();
        $totalCustomers = User::whereHas('role', function ($q) {
            $q->where('name', 'client');
        })->count();
        $totalAppointments = $bookings->count();
        $completedAppointments = $bookings->where('status', 'confirmed')->count();
        $busyWorkers = \App\Models\Employee::where('is_available', false)->count();
        $freeWorkers = \App\Models\Employee::where('is_available', true)->count();
        return view('admin.dashboard', compact('users', 'roles', 'services', 'bookings', 'totalCustomers', 'totalAppointments', 'completedAppointments', 'busyWorkers', 'freeWorkers'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id']
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully');
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id'
        ]);

        $user->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
