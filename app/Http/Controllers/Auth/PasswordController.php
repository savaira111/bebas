<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                // 'min:8',
                // 'regex:/[A-Z]/',     // huruf besar
                // 'regex:/[a-z]/',     // huruf kecil
                // 'regex:/[0-9]/',     // angka
                // 'regex:/[@$!%*#?&]/' // simbol
            ],
        ], [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
