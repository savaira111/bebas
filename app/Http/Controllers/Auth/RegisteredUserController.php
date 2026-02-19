<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // ✅ VALIDASI FORM
        $request->validate([
            'g-recaptcha-response' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
            ],
        ], [
            'g-recaptcha-response.required' => 'Captcha wajib diisi.',
        ]);

        // ✅ VERIFIKASI CAPTCHA KE GOOGLE
        $captcha = Http::asForm()->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'secret'   => config('services.recaptcha.secret'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]
        );

        if (!data_get($captcha->json(), 'success')) {
            return back()
                ->withErrors(['g-recaptcha-response' => 'Verifikasi captcha gagal.'])
                ->withInput();
        }

        // ✅ CREATE USER
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verified_at' => now(),
            'is_profile_complete' => false,
            'is_active' => 1, // aktif langsung setelah register
        ]);

        event(new Registered($user));

        // ✅ LOGIN OTOMATIS
        Auth::login($user);

        // ✅ REDIRECT KE LANDING PAGE
        return redirect()->route('home')
            ->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}
