<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting; // 1. Trait import edildi
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // 2. Trait modele dahil edildi
    use HasFactory, HasImageDeleting;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'meta_keywords' => 'array',
    ];

    // 3. Resimdeki sütun isimlerine göre silinecek dosyalar tanımlandı
    protected array $imageFields = [
        'logo',
        'favicon',
        'icon_72x72',
        'icon_192x192',
        'icon_512x512',
        'site_video'
    ];
}