<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('articles.index', compact('articles'));
    }

    public function trashed()
    {
        $articles = Article::onlyTrashed()->latest()->paginate(10);
        return view('articles.trashed', compact('articles'));
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
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['status'] = 'draft'; // Enforce draft on create

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('articles.index')->with('success', 'Article saved as draft successfully.');
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
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|in:draft,published,archived,publish', // Allow 'publish' as well
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('articles', 'public');
        }

        // Handle published_at if status changes to published
        if (($data['status'] === 'published' || $data['status'] === 'publish') && !$article->published_at) {
             $data['published_at'] = now();
             $data['status'] = 'published'; // Standardize to 'published'
        }

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Article moved to Trash');
    }

    public function restore($id)
    {
        Article::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return back()->with('success', 'Article restored successfully');
    }

    public function forceDelete($id)
    {
        Article::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return back()->with('success', 'Article permanently deleted');
    }

    public function publish($id)
    {
        $article = Article::whereNull('deleted_at')->findOrFail($id);

        $article->update([
            'status' => 'publish', // Standardize to 'published'
            'published_at' => now(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Article published successfully!');
    }
}
