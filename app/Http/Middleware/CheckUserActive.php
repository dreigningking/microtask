<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            // Check if user is active
            if (!$user->is_active) {
                // Log out the user
                Auth::logout();
                
                // Clear all sessions
                Session::flush();
                
                // Store error message in session
                Session::flash('error', 'Your account has been suspended. Please contact support for assistance.');
                
                // Redirect to login page
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Account suspended',
                        'error' => 'Your account has been suspended. Please contact support for assistance.'
                    ], 403);
                }
                
                return redirect()->route('login')->with('error', 'Your account has been suspended. Please contact support for assistance.');
            }
        }

        return $next($request);
    }
}
