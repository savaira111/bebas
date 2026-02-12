<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Album;
use App\Models\Gallery;
use App\Models\Category;
use Carbon\Carbon;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $items = collect();
        $type = strtolower($request->type);

        if (!$type || $type === 'users') {
            $items = $items->merge(User::onlyTrashed()->get());
        }

        if (!$type || $type === 'articles') {
            $items = $items->merge(Article::onlyTrashed()->get());
        }

        if (!$type || $type === 'albums') {
            $items = $items->merge(Album::onlyTrashed()->get());
        }

        if (!$type || $type === 'galleries') {
            $items = $items->merge(Gallery::onlyTrashed()->get());
        }

        if (!$type || $type === 'categories' || $type === 'category') {
            $items = $items->merge(Category::onlyTrashed()->get());
        }

        // Auto delete permanen setelah 7 hari
        foreach ($items as $item) {
            if ($item->deleted_at->addDays(7)->lt(now())) {
                $item->forceDelete();
            }
        }

        return view('trash.index', [
            'items' => $items->sortByDesc('deleted_at')
        ]);
    }

    public function restore(Request $request, $id)
    {
        $type = strtolower($request->type);

        match ($type) {
            'user', 'users' => User::onlyTrashed()->findOrFail($id)->restore(),
            'article', 'articles' => Article::onlyTrashed()->findOrFail($id)->restore(),
            'album', 'albums' => Album::onlyTrashed()->findOrFail($id)->restore(),
            'gallery', 'galleries' => Gallery::onlyTrashed()->findOrFail($id)->restore(),
            'category', 'categories' => Category::onlyTrashed()->findOrFail($id)->restore(),
            default => throw new \InvalidArgumentException("Type tidak dikenal: {$type}"),
        };

        return back()->with('success', 'Data berhasil dipulihkan');
    }

    public function forceDelete(Request $request, $id)
    {
        $type = strtolower($request->type);

        match ($type) {
            'users'      => User::onlyTrashed()->findOrFail($id)->forceDelete(),
            'article', 'articles' => Article::onlyTrashed()->findOrFail($id)->forceDelete(),
            'albums'     => Album::onlyTrashed()->findOrFail($id)->forceDelete(),
            'galleries'  => Gallery::onlyTrashed()->findOrFail($id)->forceDelete(),
            'category', 'categories' => Category::onlyTrashed()->findOrFail($id)->forceDelete(),
            default => throw new \InvalidArgumentException("Type tidak dikenal: {$request->type}"),
        };

        return back()->with('success', 'Data dihapus permanen');
    }
}
