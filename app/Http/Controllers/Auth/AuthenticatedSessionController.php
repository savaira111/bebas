<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        if ($request->has('return_url')) {
            session(['url.intended' => $request->get('return_url')]);
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1️⃣ VALIDASI CAPTCHA
        $request->validate([
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'Captcha wajib diisi.',
        ]);

        // 2️⃣ VERIFIKASI KE GOOGLE
        $response = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret'   => config('services.recaptcha.secret'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (!data_get($response->json(), 'success')) {
            return back()
                ->withErrors(['g-recaptcha-response' => 'Verifikasi captcha gagal.'])
                ->withInput();
        }

        // 3️⃣ AUTHENTICATE USER
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 4️⃣ AKTIFKAN USER BIASA SAAT LOGIN
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            $user->is_active = 1;
            $user->save();
        }

        // 5️⃣ HANDLE INTENDED URL
        if ($url = session('url.intended')) {
            session()->forget('url.intended');
            return redirect($url);
        }

        // 6️⃣ REDIRECT BERDASARKAN ROLE
        if ($user->role === 'superadmin') {
            return redirect()->route('dashboard.superadmin');
        }

        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        // DEFAULT: USER BIASA KE LANDING PAGE
        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // NONAKTIFKAN USER BIASA SAAT LOGOUT
        if ($user && !in_array($user->role, ['admin', 'superadmin'])) {
            $user->is_active = 0;
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
