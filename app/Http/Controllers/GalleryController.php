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
            'category_id' => 'required|exists:categories,id',
            'global_title' => 'required|string|max:255',
            'global_description' => 'nullable|string',
            'items' => 'required|array|max:10',
            'items.*.type' => 'required|in:foto,video',
            'items.*.description' => 'nullable|string',
            'items.*.image' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi,mkv,webm|max:10240',
            'items.*.video_url' => 'nullable|string|max:255',
        ]);

        foreach ($request->items as $item) {
            $path = null;
            if (isset($item['image'])) {
                $path = $item['image']->store('galleries', 'public');
            }

            $gallery = Gallery::create([
                'title' => $request->global_title,
                'category_id' => $request->category_id,
                'album_id' => $request->album_id,
                'description' => $item['description'] ?? $request->global_description,
                'image' => $path,
                'video_url' => $item['video_url'] ?? null,
                'type' => $item['type'],
            ]);

            if ($path && $request->album_id) {
                $gallery->photos()->create([
                    'image' => $path,
                    'album_id' => $request->album_id,
                ]);
            }
        }

        return redirect()
            ->route('galleries.index')
            ->with('success', 'Berhasil menambahkan ' . count($request->items) . ' gallery baru');
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
            'type' => 'required|in:foto,video',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi,mkv,webm|max:10240',
            'video_url' => 'nullable|string|max:255',
        ]);

        $data = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'album_id' => $request->album_id,
            'description' => $request->description,
            'type' => $request->type,
            'video_url' => $request->video_url,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $data['image'] = $path;

            if ($request->album_id) {
                $gallery->photos()->create([
                    'image' => $path,
                    'album_id' => $request->album_id,
                ]);
            }
        }

        $gallery->update($data);

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
