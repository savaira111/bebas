<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;

class SuperAdminDashboardController extends Controller
{
    // Middleware sudah didefinisikan di routes/web.php

    public function index()
    {
        // Statistik untuk superadmin
        $totalUsers = User::where('role','user')->count();
        $totalAdmins = User::where('role','admin')->count();
        $totalSuperadmins = User::where('role','superadmin')->count();

        // Highlight Hari Ini: artikel paling banyak dibaca dan disukai
        // Asumsi: ada kolom 'views' dan 'likes' di tabel articles
        $featuredArticles = Article::orderByDesc('views')
            ->orderByDesc('likes')
            ->take(3)
            ->get();

        return view('superadmin.superadmin', compact(
            'totalUsers',
            'totalAdmins',
            'totalSuperadmins',
            'featuredArticles'
        ));
    }
}
