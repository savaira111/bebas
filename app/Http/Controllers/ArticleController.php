<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // hanya data aktif (bukan sampah)
        $articles = Article::whereNull('deleted_at')
            ->latest()
            ->get();

        return view('articles.index', compact('articles'));
    }

    public function trashed()
    {
        // data sampah (soft delete)
        $articles = Article::onlyTrashed()
            ->latest()
            ->get();

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
            'image' => 'nullable|image',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        // default draft
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

        $article->update($data);

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        // soft delete -> masuk sampah
        $article->delete();
        return back();
    }

    public function restore($id)
    {
        Article::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return back();
    }

    public function forceDelete($id)
    {
        Article::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return back();
    }

    public function publish($id)
    {
        $article = Article::findOrFail($id);
        $article->status = 'publish';
        $article->save(); // waktu publish pakai updated_at

        return redirect()->route('articles.index');
    }
}
