<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            // Kalau profil belum lengkap → ke halaman edit profile
            if (!$user->is_profile_complete) {
                return redirect()->route('profile.edit');
            }

            // Profil lengkap → redirect ke dashboard sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard.admin');
            } elseif ($user->role === 'superadmin') {
                return redirect()->route('dashboard.superadmin');
            } else {
                return redirect()->route('dashboard.user');
            }
        }

        // Kalau belum verifikasi → tampil halaman verify-email
        return view('auth.verify-email');
    }
}
