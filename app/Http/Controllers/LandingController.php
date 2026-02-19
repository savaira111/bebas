<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Gallery;
use App\Models\Album;
use App\Models\Article;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EbookDownloadOtp;
use Illuminate\Support\Facades\Session;

class LandingController extends Controller
{
    /**
     * Display the landing page with featured content.
     */
    public function index()
    {
        // Best Selling Products (Proxy: Latest 4 for now as sold_count is missing)
        $products = Product::latest()->take(4)->get();

        // Most Viewed Gallery (Proxy: Latest 6 for now as views is missing)
        $galleries = Gallery::with('photos')->latest()->take(6)->get();

        // Most Read Articles (Only from regular users, excluding admins)
        $articles = Article::where('status', 'published')
            ->whereHas('user', function($q) {
                $q->where('role', 'user');
            })
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        // Most Downloaded Ebooks (Using total_download column)
        $ebooks = Ebook::orderBy('total_download', 'desc')->take(3)->get();

        return view('landing.home', compact('products', 'galleries', 'articles', 'ebooks'));
    }

    public function about()
    {
        return view('landing.about');
    }

    public function products()
    {
        $products = Product::latest()->paginate(12);
        return view('landing.products', compact('products'));
    }

    /**
     * Display a listing of albums (Portfolio page).
     */
    public function albums()
    {
        $albums = Album::withCount('galleries')->latest()->paginate(9);
        return view('landing.albums', compact('albums'));
    }

    /**
     * Display galleries within a specific album.
     */
    public function albumGalleries(Album $album)
    {
        $galleries = $album->galleries()->latest()->paginate(12);
        return view('landing.album-galleries', compact('album', 'galleries'));
    }

    /**
     * Display detail of a specific gallery item.
     * Validates that the gallery belongs to the album for security.
     */
    public function galleryDetail(Album $album, Gallery $gallery)
    {
        // Security: Validate gallery belongs to this album
        if ($gallery->album_id !== $album->id) {
            abort(404);
        }

        return view('landing.gallery-detail', compact('album', 'gallery'));
    }

    public function articles(Request $request)
    {
        $query = Article::where('status', 'published')
            ->whereHas('user', function($q) {
                $q->where('role', 'user');
            });

        // 1. Filter by Category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // 2. Sorting
        $filter = $request->get('filter', 'latest');
        switch ($filter) {
            case 'popular':
                $query->withCount('likes')->orderBy('likes_count', 'desc');
                break;
            case 'views':
                $query->orderBy('views', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = \App\Models\Category::all(); // For filter dropdown/buttons

        return view('landing.articles', compact('articles', 'filter', 'categories'));
    }

    public function showArticle(Article $article)
    {
        // Increment views
        $article->increment('views');

        // Load comments with user info, category, and author
        $article->load(['comments.user', 'category', 'user']);

        return view('landing.article-detail', compact('article'));
    }

    public function likeArticle(Request $request, Article $article)
    {
        $user = auth()->user();
        
        // Toggle like
        if ($article->isLikedBy($user)) {
            $article->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $article->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return back(); // Simply return back for now, or JSON if using AJAX
    }

    public function commentArticle(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $article->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function ebooks(Request $request)
    {
        $filter = $request->get('filter', 'latest');
        
        $query = Ebook::query();

        switch ($filter) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $query->orderBy('total_download', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $ebooks = $query->paginate(9)->withQueryString();

        return view('landing.ebooks', compact('ebooks', 'filter'));
    }

    public function showEbook(Ebook $ebook)
    {
        return view('landing.ebook-detail', compact('ebook'));
    }

    public function sendOtp(Request $request, Ebook $ebook)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        Session::put('ebook_otp_' . $ebook->id, [
            'otp' => $otp,
            'name' => $request->name,
            'email' => $request->email,
            'expires_at' => now()->addMinutes(10),
        ]);

        try {
            Mail::to($request->email)->send(new EbookDownloadOtp($otp, $request->name, $ebook->title));
            return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send OTP. Please check your email configuration.'], 500);
        }
    }

    public function verifyOtp(Request $request, Ebook $ebook)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $sessionData = Session::get('ebook_otp_' . $ebook->id);

        if (!$sessionData || $sessionData['otp'] !== $request->otp || now()->greaterThan($sessionData['expires_at'])) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.'], 422);
        }

        Session::put('ebook_verified_' . $ebook->id, true);

        return response()->json(['success' => true]);
    }

    public function downloadEbook(Request $request, Ebook $ebook)
    {
        // 1. Check if auth is required
        if ($ebook->is_auth_required && !auth()->check()) {
            return back()->with('error', 'Silakan login terlebih dahulu untuk mengunduh e-book ini.');
        }

        // 2. If guest and public, check OTP verification
        if (!auth()->check() && !Session::get('ebook_verified_' . $ebook->id)) {
             return back()->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        // 3. Increment Download Count
        $ebook->increment('total_download');

        // 4. Serve File Check
        $filePath = public_path('storage/' . $ebook->pdf);
        
        if (!file_exists($filePath)) {
            $filePath = public_path($ebook->pdf);
             if (!file_exists($filePath)) {
                abort(404, 'File ebook tidak ditemukan.');
             }
        }

        // Clear verification session after download start
        Session::forget('ebook_verified_' . $ebook->id);
        Session::forget('ebook_otp_' . $ebook->id);

        return response()->download($filePath);
    }

    public function show(Product $product)
    {
        // Get related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('landing.product-detail', compact('product', 'relatedProducts'));
    }

    public function contact()
    {
        return view('landing.contact');
    }
}
