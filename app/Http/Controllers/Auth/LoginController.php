<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isManager()) {
            return redirect()->route('manager.dashboard');
        } elseif ($user->isEmployee()) {
            return redirect()->route('employee.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }
}
