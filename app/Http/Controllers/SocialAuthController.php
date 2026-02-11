<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)
            ->with([
                'prompt' => 'select_account', // <= Memaksa pilih akun Google
            ])
            ->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::where($provider . '_id', $socialUser->getId())
                        ->orWhere('email', $socialUser->getEmail())
                        ->first();

            if (!$user) {
                // Buat user baru + belum verified + profil belum lengkap
                $user = User::create([
                    'name'               => $socialUser->getName(),
                    'email'              => $socialUser->getEmail(),
                    'password'           => bcrypt(Str::random(16)),
                    'role'               => 'user',
                    $provider . '_id'    => $socialUser->getId(),
                    'avatar'             => $socialUser->getAvatar(),
                    'email_verified_at'  => now(),
                    'is_profile_complete'=> false,
                ]);

                Auth::login($user, true);

                return redirect()->route('profile.edit')
                    ->with('success', 'Akun berhasil dibuat! Silakan lengkapi profil Anda.');
            }

            if (empty($user->{$provider . '_id'})) {
                $user->update([
                    $provider . '_id' => $socialUser->getId(),
                    'avatar'          => $socialUser->getAvatar(),
                ]);
            }

            Auth::login($user, true);

            if (!$user->is_profile_complete) {
                return redirect()->route('profile.edit')
                    ->with('info', 'Silakan lengkapi profil Anda sebelum mengakses halaman lain.');
            }

            return $this->redirectBasedOnRole($user);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan ' . ucfirst($provider));
        }
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'superadmin') return redirect()->route('dashboard.superadmin');
        if ($user->role === 'admin')      return redirect()->route('dashboard.admin');
        return redirect()->route('dashboard.user');
    }
}
