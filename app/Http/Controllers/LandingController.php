<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Gallery;
use App\Models\Album;
use App\Models\Article;
use App\Models\Ebook;
use Illuminate\Http\Request;

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

        // Most Read Articles (Using views column)
        $articles = Article::orderBy('views', 'desc')->take(3)->get();

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
        $query = Article::query();

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

        // Load comments with user info
        $article->load(['comments.user', 'category']);

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

    public function downloadEbook(Request $request, Ebook $ebook)
    {
        // 1. Validate Captcha
        $request->validate([
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'Kode captcha salah, silakan coba lagi.'
        ]);

        // 2. Increment Download Count
        $ebook->increment('total_download');

        // 3. Serve File Check
        // Assuming 'pdf' stores the filename in 'storage/app/public/ebooks' or similar
        // Adjust path based on your storage configuration.
        // If it's a full URL, we might need a different approach, but usually it's a relative path.
        // Let's assume standard storage link.
        
        $filePath = public_path('storage/' . $ebook->pdf);
        
        if (!file_exists($filePath)) {
            // Fallback check if path is stored differently (e.g. without 'storage/')
            $filePath = public_path($ebook->pdf);
             if (!file_exists($filePath)) {
                abort(404, 'File ebook tidak ditemukan.');
             }
        }

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
