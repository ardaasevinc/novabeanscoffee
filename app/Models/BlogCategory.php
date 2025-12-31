<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    use HasFactory, HasImageDeleting;

    /**
     * Toplu atama yapılmayacak alanlar.
     * Boş bırakılması tüm alanların doldurulabilir olduğu anlamına gelir.
     */
    protected $guarded = [];

    /**
     * Tip dönüşümleri.
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * HasImageDeleting Trait'i için silinecek görsel sütunları.
     */
    protected array $imageFields = ['img'];

    /**
     * İlişki: Bu kategoriye ait blog yazıları.
     * Migration dosyanızdaki 'blog_category_id' sütununu referans alır.
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'blog_category_id');
    }

    /**
     * URL'lerde 'id' yerine 'slug' kullanmak istiyorsanız bu metodu ekleyin.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}