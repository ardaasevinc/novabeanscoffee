<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory, HasImageDeleting;

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'tags'         => 'array',
    ];

    protected array $imageFields = ['img'];

    /**
     * Filament'te hataya sebep olan kısım burasıydı.
     * Fonksiyon adını 'category' olarak sabitledik.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}