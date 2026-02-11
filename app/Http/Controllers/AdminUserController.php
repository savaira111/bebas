<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $users = $query->orderBy('created_at', 'desc')->get();

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
                'password' => 'required|min:8',
            ],
            [
                'username.unique' => 'Username sudah digunakan.',
                'email.unique'    => 'Email sudah terdaftar.',
                'email.email'     => 'Format email tidak valid.',
                'password.min'    => 'Password minimal 8 karakter.',
            ]
        );

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'View only for admin roles.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Forbidden.');
        }

        $request->validate(
            [
                'name'     => 'required|string|max:255',
                'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
                'email'    => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|min:8',
            ],
            [
                'username.unique' => 'Username sudah digunakan.',
                'email.unique'    => 'Email sudah terdaftar.',
                'email.email'     => 'Format email tidak valid.',
                'password.min'    => 'Password minimal 8 karakter.',
            ]
        );

        $user->update([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password
                ? Hash::make($request->password)
                : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.index')->with('error', 'Forbidden.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    // =================== TRASHED USERS ===================
    public function trashed()
    {
        $query = User::onlyTrashed();

        if (auth()->user()->role === 'admin') {
            $query->where('role', 'user');
        }

        $users = $query->orderBy('deleted_at', 'desc')->get();

        return view('admin.users.trashed', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.trashed')->with('error', 'Forbidden.');
        }

        $user->restore();

        return redirect()->route('admin.users.trashed')->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('admin.users.trashed')->with('error', 'Forbidden.');
        }

        $user->forceDelete();

        return redirect()->route('admin.users.trashed')->with('success', 'User permanently deleted.');
    }
}
