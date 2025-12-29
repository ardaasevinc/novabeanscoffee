<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory,HasImageDeleting;
    

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'tags' => 'array', // JSON veriyi diziye çevirir
    ];

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    protected array $imageFields =['img'];
}
