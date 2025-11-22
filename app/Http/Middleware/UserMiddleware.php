<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Check if user is regular user (not admin)
        if (Auth::user()->role !== 'user') {
            return redirect()->route('admin.dashboard')->with('error', 'Admins cannot access user pages');
        }

        return $next($request);
    }
}