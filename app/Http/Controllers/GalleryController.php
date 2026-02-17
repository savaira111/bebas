<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Category;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::whereNull('deleted_at')
            ->latest()
            ->paginate(10);

        return view('galleries.index', compact('galleries'));
    }

    public function trashed()
    {
        $galleries = Gallery::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view('galleries.trashed', compact('galleries'));
    }

    public function create(Request $request)
    {
        $categories = Category::whereNull('deleted_at')->get();
        $albums = Album::whereNull('deleted_at')->get();

        return view('galleries.create', compact('categories', 'albums'));
    }

    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:foto,video,balance',
            'category_id' => 'required|exists:categories,id',
            'album_id' => 'nullable|exists:albums,id',
            'description' => 'nullable|string',
            'images' => 'required|array|max:10',
            'images.*' => 'file|max:10240', // max 10MB per file
        ]);

        // Validasi tipe file sesuai type
        Gallery::validateFiles($request->file('images'), $request->type);

        $gallery = Gallery::create([
            'title' => $request->title,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'album_id' => $request->album_id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('galleries', 'public');
                if ($request->album_id) {
                    $gallery->photos()->create([
                        'image' => $path,
                        'album_id' => $request->album_id,
                    ]);
                }
            }
        }

        return redirect()->route('galleries.index')->with('success', 'Gallery berhasil ditambahkan');
    }

    public function show(Gallery $gallery)
    {
        return view('galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $categories = Category::whereNull('deleted_at')->get();
        $albums = Album::whereNull('deleted_at')->get();

        return view('galleries.edit', compact('gallery', 'categories', 'albums'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:foto,video,balance',
            'category_id' => 'required|exists:categories,id',
            'album_id' => 'nullable|exists:albums,id',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:10',
            'images.*' => 'file|max:10240',
        ]);

        if ($request->hasFile('images')) {
            Gallery::validateFiles($request->file('images'), $request->type);
        }

        $gallery->update([
            'title' => $request->title,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'album_id' => $request->album_id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('galleries', 'public');
                if ($request->album_id) {
                    $gallery->photos()->create([
                        'image' => $path,
                        'album_id' => $request->album_id,
                    ]);
                }
            }
        }

        return redirect()->route('galleries.index')->with('success', 'Gallery berhasil diupdate');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('galleries.index')->with('success', 'Gallery masuk ke sampah');
    }

    public function restore($id)
    {
        Gallery::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return back()->with('success', 'Gallery berhasil dipulihkan');
    }

    public function forceDelete($id)
    {
        $gallery = Gallery::onlyTrashed()->findOrFail($id);

        foreach ($gallery->photos as $photo) {
            Storage::disk('public')->delete($photo->image);
        }

        $gallery->forceDelete();

        return back()->with('success', 'Gallery dihapus permanen');
    }
}
