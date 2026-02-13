<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    protected $table = 'albums';
    
    protected $fillable = [
        'name', 
        'description', 
        'cover_image'
    ];

    protected $dates = [
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    /**
     * Get the photos for the album.
     */
    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class, 'album_id', 'id');
    }
}