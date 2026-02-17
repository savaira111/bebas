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
    protected function resolveModel($type)
    {
        return match ($type) {
            'user', 'users' => User::class,
            'article', 'articles' => Article::class,
            'album', 'albums' => Album::class,
            'gallery', 'galleries' => Gallery::class,
            'category', 'categories' => Category::class,
            default => throw new \InvalidArgumentException("Type tidak dikenal: {$type}"),
        };
    }

    public function index(Request $request)
    {
        $items = collect();
        $type = strtolower($request->type ?? '');

        $models = [
            'users' => User::class,
            'articles' => Article::class,
            'albums' => Album::class,
            'galleries' => Gallery::class,
            'categories' => Category::class,
        ];

        foreach ($models as $key => $model) {
            if (!$type || $type === $key || $type === rtrim($key, 's')) {
                $items = $items->merge($model::onlyTrashed()->get());
            }
        }

        // Auto delete permanen setelah 7 hari (AMAN)
        foreach ($items as $item) {
            if ($item->deleted_at && $item->deleted_at->copy()->addDays(7)->lt(now())) {
                $item->forceDelete();
            }
        }

        return view('trash.index', [
            'items' => $items->sortByDesc('deleted_at')
        ]);
    }

    public function restore(Request $request, $id)
    {
        $type = strtolower($request->type ?? '');
        $model = $this->resolveModel($type);

        $model::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Data berhasil dipulihkan');
    }

    public function forceDelete(Request $request, $id)
    {
        $type = strtolower($request->type ?? '');
        $model = $this->resolveModel($type);

        $model::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Data dihapus permanen');
    }
}
