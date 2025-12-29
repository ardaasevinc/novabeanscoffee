<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting; // 1. Trait import edildi
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    // 2. Trait modele dahil edildi
    use HasFactory, HasImageDeleting;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
    ];

    // 3. Silinecek resim alanı belirtildi (Veritabanındaki sütun adı 'img' ise)
    protected array $imageFields = ['img'];

    // Menü Kategorisine olan ilişki
    public function menuCategory(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }
}