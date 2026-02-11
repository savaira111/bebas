<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Album;
use App\Models\Gallery;
use App\Models\Category;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $items = collect();

        $type = $request->type;

        if (!$type || $type === 'users') {
            $items = $items->merge(
                User::onlyTrashed()->get()
            );
        }

        if (!$type || $type === 'articles') {
            $items = $items->merge(
                Article::onlyTrashed()->get()
            );
        }

        if (!$type || $type === 'albums') {
            $items = $items->merge(
                Album::onlyTrashed()->get()
            );
        }

        if (!$type || $type === 'galleries') {
            $items = $items->merge(
                Gallery::onlyTrashed()->get()
            );
        }

        if (!$type || $type === 'categories') {
            $items = $items->merge(
                Category::onlyTrashed()->get()
            );
        }

        return view('trash.index', [
            'items' => $items->sortByDesc('deleted_at')
        ]);
    }

    public function restore(Request $request, $id)
    {
        match ($request->type) {
            'users'      => User::onlyTrashed()->findOrFail($id)->restore(),
            'article', 'articles' => Article::onlyTrashed()->findOrFail($id)->restore(),
            'albums'     => Album::onlyTrashed()->findOrFail($id)->restore(),
            'galleries'  => Gallery::onlyTrashed()->findOrFail($id)->restore(),
            'categories' => Category::onlyTrashed()->findOrFail($id)->restore(),
            default => throw new \InvalidArgumentException("Type tidak dikenal: {$request->type}"),
        };

        return back()->with('success', 'Data berhasil dipulihkan');
    }

    public function forceDelete(Request $request, $id)
    {
        match ($request->type) {
            'users'      => User::onlyTrashed()->findOrFail($id)->forceDelete(),
            'articles'   => Article::onlyTrashed()->findOrFail($id)->forceDelete(),
            'albums'     => Album::onlyTrashed()->findOrFail($id)->forceDelete(),
            'galleries'  => Gallery::onlyTrashed()->findOrFail($id)->forceDelete(),
            'categories' => Category::onlyTrashed()->findOrFail($id)->forceDelete(),
        };

        return back()->with('success', 'Data dihapus permanen');
    }
}
