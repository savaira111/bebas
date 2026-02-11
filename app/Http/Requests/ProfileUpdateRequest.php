<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // pastikan user sudah login
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],

            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9._]+$/', // mirip email style
                Rule::unique('users')->ignore($this->user()->id),
            ],


            // Password update rules
            'password' => [
                'nullable',
                'string',
                'min:8', // minimal 8 karakter
                'confirmed', // harus ada field password_confirmation
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).+$/',
                // minimal 1 huruf (besar/kecil bebas), 1 angka, 1 simbol
            ],
        ];
    }

    /**
     * Custom messages for validation.
     */
    public function messages(): array
    {
        return [
            // USERNAME
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 20 karakter.',
            'username.regex' => 'Username hanya boleh huruf, angka, titik, dan underscore.',
            'username.unique' => 'Username sudah digunakan.',


            'password.regex' => 'Password must contain at least one letter, one number, and one symbol.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
