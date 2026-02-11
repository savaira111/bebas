<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'deleted_at'   => 'datetime',
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }
}
