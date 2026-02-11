<?php

// app/Models/AlbumPhoto.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlbumPhoto extends Model
{
    use softDeletes;

    protected $fillable = ['gallery_id', 'image', 'caption'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }
}
