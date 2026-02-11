<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // 🔥 Bypass verifikasi untuk admin & superadmin
            if ($user->isAdmin() || $user->isSuperAdmin()) {
                return $next($request);
            }

            // Untuk user biasa: cek email_verified_at
            if (is_null($user->email_verified_at)) {
                Auth::logout(); // logout langsung
                return redirect()->route('login')
                    ->with('error', 'Your email is not verified. Please verify your email before logging in.');
            }
        }

        return $next($request);
    }
}
