<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Customer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Use Auth::check() or auth()->check() to verify if a user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Now that we know a user exists, check the role
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
