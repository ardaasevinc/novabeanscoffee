<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting; // 1. Trait'i içeri aktar
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    // 2. Trait'i kullan
    use HasFactory, HasImageDeleting;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // 3. Silinecek dosya sütunlarını belirle
    // Eğer veritabanında sütun adı 'img' değilse burayı değiştir (örn: ['icon'] veya ['banner'])
    protected array $imageFields = ['img'];
    
    public function blogs() { return $this->hasMany(Blog::class); }
}