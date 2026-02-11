<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total user role=user yang sudah verified
        $totalUsers = User::where('role', 'user')
                          ->whereNotNull('email_verified_at')
                          ->count();

        // Recent Registrations: user baru 7 hari terakhir yang sudah verified
        $recentUsers = User::where('role', 'user')
                           ->whereNotNull('email_verified_at')
                           ->where('created_at', '>=', Carbon::now()->subDays(7))
                           ->count();

        return view('admin.dashboard', compact('totalUsers', 'recentUsers'));
    }
}
