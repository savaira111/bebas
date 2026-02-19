<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('user_id', auth()->id())->latest()->paginate(10);
        return view('user.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('user.articles.create', compact('categories'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'title' => 'required',
            'content' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['title']);
        $data['status'] = 'draft';

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('user.articles.index')->with('success', 'Artikel berhasil disimpan sebagai draf.');
    }

    public function edit(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('user.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $r, Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $r->validate([
            'title' => 'required',
            'content' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $data['slug'] = Str::slug($data['title']);
        
        if ($r->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('user.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    public function submit($id)
    {
        $article = Article::findOrFail($id);
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($article->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Artikel sudah dalam peninjauan atau telah diterbitkan.');
        }

        $article->update([
            'status' => 'pending'
        ]);

        return back()->with('success', 'Artikel berhasil dikirim untuk ditinjau.');
    }
}
