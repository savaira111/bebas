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
use App\Http\Controllers\TrashController;
use App\Models\User;
use App\Http\Controllers\EbookController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::controller(\App\Http\Controllers\LandingController::class)->group(function () {

    Route::get('/about', 'about')->name('landing.about');

    Route::get('/shop', 'products')->name('landing.products');
    Route::get('/shop/{product}', 'show')->name('landing.products.show');

    Route::get('/portfolio', 'albums')->name('landing.galleries');
    Route::get('/portfolio/{album}', 'albumGalleries')->name('landing.album.galleries');
    Route::get('/portfolio/{album}/{gallery}', 'galleryDetail')->name('landing.gallery.detail');

    Route::get('/artikel', 'articles')->name('landing.articles');
    Route::get('/artikel/{article}', 'showArticle')->name('landing.articles.show');

    Route::post('/artikel/{article}/like', 'likeArticle')
        ->middleware('auth')
        ->name('landing.articles.like');

    Route::post('/artikel/{article}/comment', 'commentArticle')
        ->middleware('auth')
        ->name('landing.articles.comment');

    Route::get('/blog', fn() => redirect()->route('landing.articles'));

    Route::get('/library', 'ebooks')->name('landing.ebooks');
    Route::get('/library/{ebook}', 'showEbook')->name('landing.ebooks.show');

    Route::post('/library/{ebook}/download', 'downloadEbook')
        ->name('landing.ebooks.download');

    Route::post('/library/{ebook}/send-otp', 'sendOtp')
        ->name('landing.ebooks.send-otp');

    Route::post('/library/{ebook}/verify-otp', 'verifyOtp')
        ->name('landing.ebooks.verify-otp');

    Route::get('/contact', 'contact')->name('landing.contact');
});

Route::get('/login-redirect', fn() => redirect()->route('login'))
    ->name('login.redirect');

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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/send-username-verification',
        [ProfileController::class, 'sendUsernameVerification']
    )->name('profile.send-username-verification');
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

        Route::get('/trash', [TrashController::class, 'index'])
            ->name('trash.index');

        Route::post('/trash/{id}/restore', [TrashController::class, 'restore'])
            ->name('trash.restore');

        Route::delete('/trash/{id}/force', [TrashController::class, 'forceDelete'])
            ->name('trash.forceDelete');
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

    Route::delete('/superadmin/users/{id}/destroy-confirm',
        [UserManagementController::class, 'destroyConfirm']
    )->name('superadmin.users.destroy.confirm');
});

/*
|--------------------------------------------------------------------------
| ALBUM ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/albums/trashed', [AlbumController::class, 'trashed'])->name('albums.trashed');
    Route::post('/albums/{id}/restore', [AlbumController::class, 'restore'])->name('albums.restore');
    Route::delete('/albums/{id}/force-delete', [AlbumController::class, 'forceDelete'])->name('albums.forceDelete');

    Route::post('/albums/{album}/photos', [AlbumPhotoController::class, 'store'])->name('albums.photos.store');
    Route::delete('/photos/{photo}', [AlbumPhotoController::class, 'destroy'])->name('photos.destroy');

    Route::resource('albums', AlbumController::class);
});

/*
|--------------------------------------------------------------------------
| GALLERIES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('galleries/trashed', [GalleryController::class, 'trashed'])->name('galleries.trashed');
    Route::post('galleries/{gallery}/restore', [GalleryController::class, 'restore'])->name('galleries.restore');
    Route::delete('galleries/{gallery}/force-delete', [GalleryController::class, 'forceDelete'])->name('galleries.forceDelete');

    Route::resource('galleries', GalleryController::class);
});

/*
|--------------------------------------------------------------------------
| CATEGORY ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('categories/trashed', [\App\Http\Controllers\CategoryController::class, 'trashed'])
        ->name('categories.trashed');

    Route::post('categories/{category}/restore', [\App\Http\Controllers\CategoryController::class, 'restore'])
        ->name('categories.restore');

    Route::delete('categories/{category}/force-delete', [\App\Http\Controllers\CategoryController::class, 'forceDelete'])
        ->name('categories.forceDelete');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| EBOOK ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('ebooks/trashed', [EbookController::class, 'trashed'])->name('ebooks.trashed');
    Route::post('ebooks/{id}/restore', [EbookController::class, 'restore'])->name('ebooks.restore');
    Route::delete('ebooks/{id}/force-delete', [EbookController::class, 'forceDelete'])->name('ebooks.forceDelete');

    Route::resource('ebooks', EbookController::class);
});

/*
|--------------------------------------------------------------------------
| REALTIME CHECK (SUPERADMIN)
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
Route::post('articles/{article}/publish', [ArticleController::class, 'publish'])
    ->name('articles.publish');

Route::get('articles/trashed', [ArticleController::class, 'trashed'])
    ->name('articles.trashed');

Route::post('articles/{article}/restore', [ArticleController::class, 'restore'])
    ->name('articles.restore');

Route::delete('articles/{article}/force-delete', [ArticleController::class, 'forceDelete'])
    ->name('articles.forceDelete');

Route::resource('articles', ArticleController::class);

/*
|--------------------------------------------------------------------------
| PRODUCTS ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('products/trashed', [\App\Http\Controllers\ProductController::class, 'trashed'])
        ->name('products.trashed');

    Route::post('products/{product}/restore', [\App\Http\Controllers\ProductController::class, 'restore'])
        ->name('products.restore');

    Route::delete('products/{product}/force-delete', [\App\Http\Controllers\ProductController::class, 'forceDelete'])
        ->name('products.forceDelete');

    Route::resource('products', \App\Http\Controllers\ProductController::class);
});
