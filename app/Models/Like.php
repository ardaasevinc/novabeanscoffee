<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'is_liked',
        'user_name',
        'user_comment',
        'is_published',
        'ip_address'
    ];
}