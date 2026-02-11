<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'cover_image'];

    protected $dates = ['deleted_at'];

    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class);
    }
}
