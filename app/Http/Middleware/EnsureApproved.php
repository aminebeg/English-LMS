<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check() && !\Illuminate\Support\Facades\Auth::user()->is_approved) {
            \Illuminate\Support\Facades\Auth::logout();
            return redirect()->route('login')->with('status', 'Your account is pending approval.');
        }

        return $next($request);
    }
}
