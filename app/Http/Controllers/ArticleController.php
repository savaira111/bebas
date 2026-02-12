<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function trashed()
    {
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

        $data['slug'] = Str::slug($data['title']);
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
        $data = $r->validate([
            'title' => 'required',
            'content' => 'nullable',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        $data['status'] = 'publish';
        $data['published_at'] = now();

        $article->update($data);

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
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
        $article = Article::whereNull('deleted_at')->findOrFail($id);

        $article->update([
            'status' => 'publish',
            'published_at' => now(),
        ]);

        return redirect()->route('articles.index');
    }
}
