<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        return view('albums.index', [
            'albums' => Album::withTrashed()->latest()->get()
        ]);
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image'
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('albums', 'public');
        }

        Album::create($data);

        return redirect()->route('albums.index');
    }

    public function show($id)
    {
        $album = Album::withTrashed()->findOrFail($id);
        $album->load('photos');

        return view('albums.show', compact('album'));
    }

    public function edit($id)
    {
        $album = Album::withTrashed()->findOrFail($id);
        return view('albums.edit', compact('album'));
    }

    public function update(Request $request, $id)
    {
        $album = Album::withTrashed()->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')
                ->store('albums', 'public');
        }

        $album->update($data);

        return redirect()->route('albums.index');
    }

    public function destroy($id)
{
    $album = Album::withTrashed()->findOrFail($id);

    if (!$album->trashed()) {
        $album->delete(); // soft delete
    }

    return redirect()->route('albums.index');
}


    public function trashed()
    {
        $albums = Album::onlyTrashed()->latest()->get();
        return view('albums.trashed', compact('albums'));
    }

    public function restore($id)
    {
        $album = Album::withTrashed()->findOrFail($id);
        $album->restore();

        return redirect()->route('albums.index');
    }

    public function forceDelete($id)
    {
        $album = Album::withTrashed()->findOrFail($id);

        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        foreach ($album->photos as $photo) {
            Storage::disk('public')->delete($photo->image);
        }

        $album->forceDelete();

        return redirect()->route('albums.index');
    }
}
