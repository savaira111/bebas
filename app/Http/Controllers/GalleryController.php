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
        $galleries = Gallery::latest()->paginate(10);
        return view('galleries.index', compact('galleries'));
    }

    public function trashed()
    {
        $galleries = Gallery::onlyTrashed()->latest()->paginate(10);
        return view('galleries.trashed', compact('galleries'));
    }

    public function create()
    {
        $categories = Category::all();
        $albums = Album::all();

        return view('galleries.create', compact('categories', 'albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'album_id' => 'nullable|exists:albums,id',
            'description' => 'nullable|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,mp4|max:10240',
        ]);

        $type = 'foto';

        $path = null;

        if ($request->hasFile('image')) {

            // FIX ERROR ARRAY
            Gallery::validateFiles([$request->file('image')], $type);

            $path = $request->file('image')->store('galleries', 'public');
        }

        // FIX ERROR SQL (WAJIB ISI IMAGE)
        $gallery = Gallery::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'album_id' => $request->album_id,
            'description' => $request->description,
            'image' => $path, // WAJIB ADA
        ]);

        // Optional kalau mau tetap simpan ke photos juga
        if ($path && $request->album_id) {
            $gallery->photos()->create([
                'image' => $path,
                'album_id' => $request->album_id,
            ]);
        }

        return redirect()
            ->route('galleries.index')
            ->with('success', 'Gallery berhasil ditambahkan');
    }

    public function show(Gallery $gallery)
    {
        return view('galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $categories = Category::all();
        $albums = Album::all();

        return view('galleries.edit', compact('gallery', 'categories', 'albums'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'album_id' => 'nullable|exists:albums,id',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240',
        ]);

        $type = 'foto';

        $gallery->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'album_id' => $request->album_id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image') && $request->album_id) {

            Gallery::validateFiles([$request->file('image')], $type);

            $path = $request->file('image')->store('galleries', 'public');

            // update kolom image di galleries
            $gallery->update([
                'image' => $path,
            ]);

            $gallery->photos()->create([
                'image' => $path,
                'album_id' => $request->album_id,
            ]);
        }

        return redirect()
            ->route('galleries.index')
            ->with('success', 'Gallery berhasil diupdate');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()
            ->route('galleries.index')
            ->with('success', 'Gallery masuk ke sampah');
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

        // hapus file utama
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        // hapus relasi photos
        foreach ($gallery->photos as $photo) {
            Storage::disk('public')->delete($photo->image);
            $photo->delete();
        }

        $gallery->forceDelete();

        return back()->with('success', 'Gallery dihapus permanen');
    }
}
