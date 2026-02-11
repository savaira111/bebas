<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumPhotoController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ArticleController;
use App\Models\User;

/*
|-------------------------------------------------------------------------- 
| ROOT
|-------------------------------------------------------------------------- 
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|-------------------------------------------------------------------------- 
| AUTH ROUTES
|-------------------------------------------------------------------------- 
*/
require __DIR__ . '/auth.php';

/*
|-------------------------------------------------------------------------- 
| USER ROUTES
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])
        ->name('profile.avatar.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // ✅ FIX ERROR ROUTE NOT FOUND
    Route::post('/profile/send-username-verification', [ProfileController::class, 'sendUsernameVerification'])
        ->name('profile.send-username-verification');
});

Route::middleware(['auth', 'verified', 'profile.complete'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.user');
    })->name('dashboard.user');
});

/*
|-------------------------------------------------------------------------- 
| ADMIN ROUTES
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard.admin');

    Route::get('/admin/users/trashed', [AdminUserController::class, 'trashed'])
        ->name('admin.users.trashed');

    Route::post('/admin/users/{id}/restore', [AdminUserController::class, 'restore'])
        ->name('admin.users.restore');

    Route::delete('/admin/users/{id}/force', [AdminUserController::class, 'forceDelete'])
        ->name('admin.users.forceDelete');

    Route::resource('/admin/users', AdminUserController::class)->names([
        'index'   => 'admin.users.index',
        'create'  => 'admin.users.create',
        'store'   => 'admin.users.store',
        'edit'    => 'admin.users.edit',
        'update'  => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});

/*
|-------------------------------------------------------------------------- 
| SUPERADMIN ROUTES
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'role:superadmin'])->group(function () {

    Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'index'])
        ->name('dashboard.superadmin');

    Route::prefix('superadmin/users')->name('superadmin.users.')->group(function () {

        Route::get('/trashed', [UserManagementController::class, 'trashed'])
            ->name('trashed');

        Route::post('/{id}/restore', [UserManagementController::class, 'restore'])
            ->name('restore');

        Route::delete('/{id}/force', [UserManagementController::class, 'forceDelete'])
            ->name('forceDelete');
    });

    Route::resource('/superadmin/users', UserManagementController::class)->names([
        'index'   => 'superadmin.users.index',
        'create'  => 'superadmin.users.create',
        'store'   => 'superadmin.users.store',
        'show'    => 'superadmin.users.show',
        'edit'    => 'superadmin.users.edit',
        'update'  => 'superadmin.users.update',
        'destroy' => 'superadmin.users.destroy',
    ]);

    Route::delete(
        '/superadmin/users/{id}/destroy-confirm',
        [UserManagementController::class, 'destroyConfirm']
    )->name('superadmin.users.destroy.confirm');
});

/*
|-------------------------------------------------------------------------- 
| ALBUM & PRODUCT GALLERY ROUTES
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('albums', AlbumController::class);
    Route::post('/albums/{album}/photos', [AlbumPhotoController::class, 'store'])
        ->name('albums.photos.store');
    Route::delete('/photos/{photo}', [AlbumPhotoController::class, 'destroy'])
        ->name('photos.destroy');
});

/*
|-------------------------------------------------------------------------- 
| GALLERIES
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('galleries', GalleryController::class);
});

/*
|-------------------------------------------------------------------------- 
| CATEGORY ROUTES
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});

/*
|-------------------------------------------------------------------------- 
| REALTIME CHECK USERNAME & EMAIL (SUPERADMIN)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth'])->post('/superadmin/check-username', function (Request $request) {
    return response()->json([
        'exists' => User::where('username', $request->username)->exists()
    ]);
})->name('superadmin.check.username');

Route::middleware(['auth'])->post('/superadmin/check-email', function (Request $request) {
    return response()->json([
        'exists' => User::where('email', $request->email)->exists()
    ]);
})->name('superadmin.check.email');

/*
|-------------------------------------------------------------------------- 
| SOCIAL LOGIN
|-------------------------------------------------------------------------- 
*/
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->name('social.redirect');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->name('social.callback');

/*
|-------------------------------------------------------------------------- 
| ARTICLES
|-------------------------------------------------------------------------- 
*/
Route::resource('articles', ArticleController::class);

Route::post('articles/{id}/publish', [ArticleController::class, 'publish'])
    ->name('articles.publish');

/* 🔥 TAMBAHAN SOFT DELETE (SAMPAH) */
Route::get('articles-trashed', [ArticleController::class, 'trashed'])
    ->name('articles.trashed');

Route::post('articles/{id}/restore', [ArticleController::class, 'restore'])
    ->name('articles.restore');

Route::delete('articles/{id}/force', [ArticleController::class, 'forceDelete'])
    ->name('articles.forceDelete');

/*
|-------------------------------------------------------------------------- 
| ALBUMS – SOFT DELETE
|-------------------------------------------------------------------------- 
*/
Route::get('albums-trashed', [AlbumController::class, 'trashed'])
    ->name('albums.trashed');

Route::post('albums/{id}/restore', [AlbumController::class, 'restore'])
    ->name('albums.restore');

Route::delete('albums/{id}/force', [AlbumController::class, 'forceDelete'])
    ->name('albums.forceDelete');

/*
|-------------------------------------------------------------------------- 
| GALLERIES – SOFT DELETE
|-------------------------------------------------------------------------- 
*/
Route::get('galleries-trashed', [GalleryController::class, 'trashed'])
    ->name('galleries.trashed');

Route::post('galleries/{id}/restore', [GalleryController::class, 'restore'])
    ->name('galleries.restore');

Route::delete('galleries/{id}/force', [GalleryController::class, 'forceDelete'])
    ->name('galleries.forceDelete');

/*
|-------------------------------------------------------------------------- 
| CATEGORIES – SOFT DELETE
|-------------------------------------------------------------------------- 
*/
Route::get('categories-trashed', [\App\Http\Controllers\CategoryController::class, 'trashed'])
    ->name('categories.trashed');

Route::post('categories/{id}/restore', [\App\Http\Controllers\CategoryController::class, 'restore'])
    ->name('categories.restore');

Route::delete('categories/{id}/force', [\App\Http\Controllers\CategoryController::class, 'forceDelete'])
    ->name('categories.forceDelete');
