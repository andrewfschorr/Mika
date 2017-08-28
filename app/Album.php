<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $casts = [
        'images' => 'array',
    ];
}
