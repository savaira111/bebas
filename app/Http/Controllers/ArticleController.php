<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // otomatis hanya data aktif (bukan sampah)
        $articles = Article::latest()->get();

        return view('articles.index', compact('articles'));
    }

    public function trashed()
    {
        // data sampah
        $articles = Article::onlyTrashed()->latest()->get();

        return view('articles.trashed', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'title' => 'required',
            'content' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $data['status'] = 'draft';

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $r, Article $article)
    {
        $data = $r->only([
            'title',
            'content',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ]);

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        $article->update([
            'status' => 'publish',
            'published_at' => now(),
        ]);

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        // SOFT DELETE -> masuk sampah
        $article->delete();

        return back()->with('success', 'Artikel dipindahkan ke Sampah');
    }

    public function restore($id)
    {
        Article::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return back()->with('success', 'Artikel berhasil dipulihkan');
    }

    public function forceDelete($id)
    {
        Article::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return back()->with('success', 'Artikel dihapus permanen');
    }

    public function publish($id)
    {
        // JANGAN publish artikel di sampah
        $article = Article::whereNull('deleted_at')->findOrFail($id);

        $article->update([
            'status' => 'publish',
            'published_at' => now(), // opsional tapi REKOMENDASI
        ]);

        return redirect()->route('articles.index');
    }
}
