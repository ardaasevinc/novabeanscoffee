<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting; // 1. Trait import edildi
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrollTicker extends Model
{
    // 2. Trait kullanıldı
    use HasFactory, HasImageDeleting;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // 3. Silinecek alan adı 'icon' olarak belirtildi
    protected array $imageFields = ['icon'];
}