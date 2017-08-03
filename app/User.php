<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'igAttrs' => 'array',
        'options' => 'array',
    ];

    /**
     * All of the user's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'options' => '{}',
        'igAttrs' => '{}',
    ];

    protected $igFields = ['id', 'username', 'full_name', 'profile_picture', 'bio', 'website'];


    protected $default_opts = [
        'foo' => 'this will always be included',
    ];

    // private function setInitialIgFields()
    // {
    //     $igAttrs = $this->igAttrs;
    //     foreach ($this->igFields as $igField) {
    //         $igAttrs
    //     }
    // }

    private function setValues(array $source = [], array $dest = [])
    {
        echo 'hiii';
        foreach ($source as $key => $val) {

        }
    }

    private function setValue($key, $value, array $arr)
    {
        $arr[$key] = $value;
        return $arr;
    }

    private function deletevalue($key, array $arr)
    {
        $opts = $this->options;
        $array_key_exists = array_key_exists($key, $opts);
        if ($array_key_exists) {
            unset($opts[$key]);
            $this->options = $opts;
        }
        return $array_key_exists;
    }

    public function __construct(array $attributes = array())
    {
        // $this->options = array_merge($this->default_opts, $this->options);
        // $this->setInitialIgFields();
        parent::__construct($attributes);
    }
}