<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ebook extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cover', 'title', 'author', 'description', 'pdf', 'total_download', 'slug', 'is_auth_required', 'category',
    ];

    protected $dates = ['deleted_at'];
}
