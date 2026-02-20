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
        'album_id',
        'category_id',
        'image',
        'video_url',
        'type',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke photos gallery (sesuai struktur tabel album_photos yang menggunakan album_id)
    public function photos()
    {
        return $this->hasMany(AlbumPhoto::class, 'album_id', 'album_id');
    }

    // Alias untuk kemudahan di view
    public function getImagesAttribute()
    {
        return $this->photos()->get();
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Validasi file upload untuk type gallery
     * @param array $files
     * @return array
     * @throws \Exception
     */
    public static function validateFiles(array $files, string $type)
    {
        if (count($files) > 10) {
            throw new \Exception("Maksimal 10 file saja");
        }

        foreach ($files as $file) {
            $ext = strtolower($file->getClientOriginalExtension());
            if ($type === 'foto' && !in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                throw new \Exception("Tipe foto hanya bisa gambar");
            }
            if ($type === 'video' && !in_array($ext, ['mp4','mov','avi','mkv','webm'])) {
                throw new \Exception("Tipe video hanya bisa video");
            }
            // balance bisa semua, tidak perlu cek
        }
    }
}
