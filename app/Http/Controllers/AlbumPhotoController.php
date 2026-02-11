<?php

// app/Http/Controllers/AlbumPhotoController.php
namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumPhotoController extends Controller
{
    public function store(Request $request, Album $album)
    {
        $request->validate([
            'image' => 'required|image',
            'caption' => 'nullable|string'
        ]);

        $path = $request->file('image')
            ->store('albums/photos', 'public');

        $album->photos()->create([
            'image' => $path,
            'caption' => $request->caption
        ]);

        return back();
    }

    public function destroy(AlbumPhoto $photo)
    {
        Storage::disk('public')->delete($photo->image);
        $photo->delete();

        return back();
    }
}
