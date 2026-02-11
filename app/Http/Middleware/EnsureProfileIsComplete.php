<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Jika user login & profil belum lengkap, redirect ke halaman edit profil
        if ($user && !$user->is_profile_complete) {
            if (!$request->is('profile*')) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Silakan lengkapi profil terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
