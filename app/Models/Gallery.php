<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'album_id',
        'category_id',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    protected $dates = ['deleted_at'];

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class, 'album_id');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
