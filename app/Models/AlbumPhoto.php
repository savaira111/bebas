<?php

// app/Models/AlbumPhoto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumPhoto extends Model
{
    protected $fillable = ['gallery_id', 'image', 'caption'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}
