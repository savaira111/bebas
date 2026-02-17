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
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $casts = [
        'deleted_at'   => 'datetime',
        'published_at' => 'datetime',
    ];

    protected $withCount = ['likes', 'comments'];

    protected static function booted()
    {
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationships
    public function likes()
    {
        return $this->hasMany(ArticleLike::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // Helpers
    public function isLikedBy(?User $user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Scopes
    public function scopePopular($query)
    {
        return $query->withCount('likes')->orderBy('likes_count', 'desc');
    }

    public function scopeMostViewed($query)
    {
        return $query->orderBy('views', 'desc');
    }
}
