<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Redirect users based on their role
     */
    protected function redirectBasedOnRole()
    {
        $user = User::with('role')->find(Auth::id());

        if (!$user || !$user->role) {
            return redirect()->route('client.dashboard');
        }

        switch ($user->role->name) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'manager':
                return redirect()->route('manager.dashboard');
            case 'employee':
                return redirect()->route('employee.dashboard');
            default:
                return redirect()->route('client.dashboard');
        }
    }
}
