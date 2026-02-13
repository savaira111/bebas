<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Album::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
        }

        $albums = $query->latest()->paginate(10);

        return view('albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('albums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $album = new Album();
        $album->name = $request->name;
        $album->description = $request->description;
        
        if ($request->hasFile('cover_image')) {
            $album->cover_image = $request->file('cover_image')
                ->store('albums/covers', 'public');
        }
        
        $album->save();

        return redirect()->route('albums.index')
            ->with('success', 'Album created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $album = Album::withTrashed()->with('photos')->findOrFail($id);
        return view('albums.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $album = Album::withTrashed()->findOrFail($id);
        return view('albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $album = Album::withTrashed()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $album->name = $request->name;
        $album->description = $request->description;
        
        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $album->cover_image = $request->file('cover_image')
                ->store('albums/covers', 'public');
        }
        
        $album->save();

        return redirect()->route('albums.index')
            ->with('success', 'Album updated successfully.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy($id)
    {
        try {
            $album = Album::findOrFail($id);
            $albumName = $album->name;
            $album->delete();

            return redirect()->route('albums.index')
                ->with('success', 'Album "' . $albumName . '" moved to trash successfully.');
        } catch (\Exception $e) {
            return redirect()->route('albums.index')
                ->with('error', 'Failed to delete album. Please try again.');
        }
    }

    /**
     * Display trashed albums.
     */
    public function trashed(Request $request)
    {
        $query = Album::onlyTrashed();
        
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        
        $albums = $query->latest('deleted_at')->paginate(10);
        
        return view('albums.trashed', compact('albums'));
    }

    /**
     * Restore trashed album.
     */
    public function restore($id)
    {
        try {
            $album = Album::withTrashed()->findOrFail($id);
            $albumName = $album->name;
            $album->restore();
            
            return redirect()->route('albums.trashed')
                ->with('success', 'Album "' . $albumName . '" restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('albums.trashed')
                ->with('error', 'Failed to restore album. Please try again.');
        }
    }

    /**
     * Permanently delete album.
     */
    public function forceDelete($id)
    {
        try {
            $album = Album::withTrashed()->findOrFail($id);
            $albumName = $album->name;
            
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            
            foreach ($album->photos as $photo) {
                if ($photo->image) {
                    Storage::disk('public')->delete($photo->image);
                }
                $photo->forceDelete();
            }
            
            $album->forceDelete();
            
            return redirect()->route('albums.trashed')
                ->with('success', 'Album "' . $albumName . '" permanently deleted.');
        } catch (\Exception $e) {
            return redirect()->route('albums.trashed')
                ->with('error', 'Failed to delete album permanently. Please try again.');
        }
    }
}