<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting; // 1. Trait import edildi
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuCategory extends Model
{
    // 2. Trait kullanıldı
    use HasFactory, HasImageDeleting;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // 3. Silinecek resim sütunu tanımlandı
    protected array $imageFields = ['img'];

    /**
     * Kategorinin menü ürünleri ile olan ilişkisi.
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'menu_category_id');
    }
}