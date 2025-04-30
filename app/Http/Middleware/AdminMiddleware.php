<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Role;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role->name !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
