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
        if (!in_array($provider, ['google'])) {
            abort(404);
        }

        return Socialite::driver($provider)
            ->stateless()
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();
    }

    public function callback($provider)
    {
        if (!in_array($provider, ['google'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            if (!$socialUser->getEmail()) {
                return redirect()->route('login')
                    ->with('error', 'Email tidak tersedia dari akun ' . ucfirst($provider));
            }

            $user = User::where($provider . '_id', $socialUser->getId())
                ->orWhere('email', $socialUser->getEmail())
                ->first();

            if (!$user) {

                // Generate unique username
                $baseUsername = Str::slug(
                    $socialUser->getName() 
                    ?? explode('@', $socialUser->getEmail())[0]
                );

                $username = $baseUsername;
                $counter = 1;

                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }

                $user = User::create([
                    'name'               => $socialUser->getName() ?? $username,
                    'username'           => $username,
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

            // Update provider id jika belum ada
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
        if ($user->role === 'superadmin') {
            return redirect()->route('dashboard.superadmin');
        }

        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        return redirect()->route('home');
    }
}
