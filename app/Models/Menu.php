<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory, HasImageDeleting;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'has_sizes' => 'boolean', // Boyutlu ürün kontrolü
        'price' => 'decimal:2',        // Small / Standart Fiyat
        'price_medium' => 'decimal:2', // Medium Fiyat
        'price_large' => 'decimal:2',  // Large Fiyat
    ];

    // Silinecek resim alanı (Trait için)
    protected array $imageFields = ['img'];

    /**
     * Menü Kategorisine olan ilişki
     */
    public function menuCategory(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    /**
     * Helper: Ürünün başlangıç fiyatını döndürür
     */
    public function getStartingPriceAttribute()
    {
        return $this->price;
    }
}