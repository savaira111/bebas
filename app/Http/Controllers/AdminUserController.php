<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if (auth()->user()->role === 'admin') {
            $query->where('role', '!=', 'superadmin');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                    ->orWhere('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'     => 'required|string|max:255',
                'username' => 'nullable|string|max:255|unique:users,username',
                'email'    => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()   // huruf besar & kecil
                        ->numbers()     // angka
                        ->symbols(),    // simbol
                ],
            ],
            [
                'username.unique' => 'Username sudah digunakan.',
                'email.unique'    => 'Email sudah terdaftar.',
                'email.email'     => 'Format email tidak valid.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]
        );

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Hanya dapat melihat peran admin.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Akses ditolak.');
        }

        $request->validate(
            [
                'name'     => 'required|string|max:255',
                'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
                'email'    => 'required|email|unique:users,email,' . $user->id,
                'password' => [
                    'nullable',
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],
            ],
            [
                'username.unique' => 'Username sudah digunakan.',
                'email.unique'    => 'Email sudah terdaftar.',
                'email.email'     => 'Format email tidak valid.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]
        );


        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Akses ditolak.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    // =================== TRASHED USERS ===================
    public function trashed()
    {
        $query = User::onlyTrashed();

        if (auth()->user()->role === 'admin') {
            $query->where('role', 'user');
        }

        $users = $query->orderBy('deleted_at', 'desc')->paginate(10);

        return view('admin.users.trashed', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.trashed')->with('error', 'Akses ditolak.');
        }

        $user->restore();

        return redirect()->route('admin.users.trashed')->with('success', 'Pengguna berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.trashed')->with('error', 'Akses ditolak.');
        }

        $user->forceDelete();

        return redirect()->route('admin.users.trashed')->with('success', 'Pengguna berhasil dihapus permanen.');
    }
}
