<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi password (jika diisi)
        $request->validate([
            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',       // Huruf besar
                'regex:/[a-z]/',       // Huruf kecil
                'regex:/[0-9]/',       // Angka
                'regex:/[^A-Za-z0-9]/', // Simbol
            ],
        ]);

        // Simpan email lama untuk cek perubahan
        $oldEmail = $user->email;

        // Update field yang valid
        $user->fill($request->validated());

        // Update tambahan manual
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Tandai email unverified jika email diganti
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->is_profile_complete = true;

        $user->save();

        // Hanya jika email berubah → redirect ke halaman verifikasi
        if ($user->isDirty('email')) {
            return Redirect::route('verification.notice')->with('status', 'verification-required');
        }

        // Kalau cuma ganti nama, username, password, phone, address → tetap di edit profile
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'avatar-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
