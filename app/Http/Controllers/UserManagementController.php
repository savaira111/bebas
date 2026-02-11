<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    // ================= SUPERADMIN ONLY =================
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', "%{$request->search}%")
                  ->orWhere('role', 'like', "%{$request->search}%");
            });
        }

        if ($request->role && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->get();

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'admin' && $request->role !== 'user') {
            return redirect()->back()->with('error', 'Admins can only create regular users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'regex:/^\S+$/u', 'max:255', 'unique:users'],
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:admin,superadmin,user',
            'password' => 'required|min:6|confirmed',
        ], [
            'username.regex' => 'Usernames cannot contain spaces.',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User berhasil dibuat');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('superadmin.users.index')
                             ->with('error', 'Admins can only edit regular users.');
        }

        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('superadmin.users.index')
                             ->with('error', 'Admins can only update regular users.');
        }

        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => ['required','string','regex:/^\S+$/u','max:255','unique:users,username,' . $user->id],
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,user,superadmin',
        ], [
            'username.regex' => 'Username tidak boleh mengandung spasi.',
        ]);

        if (auth()->user()->role === 'admin') {
            $user->update([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'role'     => 'user',
            ]);
        } else {
            $user->update([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'role'     => $request->role,
            ]);
        }

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role === 'admin' && $user->role !== 'user') {
            return redirect()->route('superadmin.users.index')
                             ->with('error', 'Admins can only delete regular users.');
        }

        $user->delete();

        return redirect()
            ->route('superadmin.users.index')
            ->with('success', 'User moved to trash.');
    }

    public function trashed(Request $request)
    {
        $query = User::onlyTrashed();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->latest()->get();

        return view('superadmin.users.trashed', compact('users'));
    }

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'User berhasil direstore.');
    }

    public function forceDelete($id)
    {
        User::onlyTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'User berhasil dihapus permanen.');
    }

    // ================= REALTIME VALIDATION (NEW, AMAN) =================

    public function checkUsername(Request $request)
    {
        return response()->json([
            'exists' => User::where('username', $request->username)->exists()
        ]);
    }

    public function checkEmail(Request $request)
    {
        return response()->json([
            'exists' => User::where('email', $request->email)->exists()
        ]);
    }
}
