<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'name', 'album_name', 'display_name', 'images', 'user_id',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
