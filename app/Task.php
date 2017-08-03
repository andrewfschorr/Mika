<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'foo' => 'boolean',
    ];

    protected $fillable = ['body', 'options'];

    public static function incomplete()
    {
        return static::where('completed', 0)->get();
    }
}
