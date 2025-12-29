<?php

namespace App\Models;

use App\PhotoDelete\HasImageDeleting; // Trait'i import et
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory, HasImageDeleting; // Trait'i dahil et

    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Hem 'img' hem de 'video' dosyasını silmesi için buraya ekledik
    protected array $imageFields = ['img', 'video'];
}