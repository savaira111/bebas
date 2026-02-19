<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category']);

        // Filter by Search (Title)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by Author Role
        if ($request->filled('author_role')) {
            $role = $request->author_role;
            if ($role === 'user') {
                $query->whereHas('user', function($q) {
                    $q->where('role', 'user');
                });
            } elseif ($role === 'admin') {
                $query->whereHas('user', function($q) {
                    $q->whereIn('role', ['admin', 'superadmin']);
                });
            }
        }

        $articles = $query->latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'title' => 'required',
            'content' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']);
        
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $r, Article $article)
    {
        $data = $r->validate([
            'title' => 'required',
            'content' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|in:draft,published,pending,rejected',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $data['slug'] = Str::slug($data['title']);
        
        if ($data['status'] === 'published' && !$article->published_at) {
            $data['published_at'] = now();
        }

        if ($r->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Artikel berhasil dipindahkan ke sampah.');
    }

    public function trashed()
    {
        $articles = Article::onlyTrashed()->with(['user', 'category'])->latest()->paginate(10);
        return view('articles.trashed', compact('articles'));
    }

    public function restore($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        $article->restore();
        return back()->with('success', 'Artikel berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $article = Article::onlyTrashed()->findOrFail($id);
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->forceDelete();
        return back()->with('success', 'Artikel berhasil dihapus permanen.');
    }

    public function review(Request $request, Article $article)
    {
        $data = $request->validate([
            'action' => 'required|in:approve,reject',
            'reviewer_note' => 'nullable|string',
        ]);

        if ($data['action'] === 'approve') {
            $article->update([
                'status' => 'published',
                'published_at' => now(),
                'reviewer_note' => $data['reviewer_note'] ?? null,
            ]);
            $message = 'Artikel berhasil disetujui dan diterbitkan.';
        } else {
            $article->update([
                'status' => 'rejected',
                'reviewer_note' => $data['reviewer_note'],
            ]);
            $message = 'Artikel berhasil ditolak.';
        }

        return back()->with('success', $message);
    }

    public function publish($id)
    {
        $article = Article::whereNull('deleted_at')->findOrFail($id);

        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }
}
