<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
        ]);

        // Get the client role ID (should be 4 based on the seeder)
        $clientRole = \App\Models\Role::where('name', 'client')->first();
        
        if (!$clientRole) {
            // If roles haven't been seeded, we should handle this error
            return redirect()->back()->withErrors(['error' => 'Registration system is not properly configured.']);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => $clientRole->id,
        ]);

        Auth::login($user);

        return redirect()->route('client.dashboard');
    }
}
