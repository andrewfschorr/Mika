<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/*
 * This is the \User API Weeeeeeeeee
 *
 * $user = App\user::find(1);
 * $user->setOption('foo', 'bar');
 * $user->setOptions([
 *  'thing' => 'tihng t00'
 * ]);
 * $user->options['foo']
 * $user->deleteOption('foo');
 * $user->deleteOptions(['a', 'b', 'c']);
 * $user->getOption('foo');
 *
 * $user->setIg('id', 12345);
 * $user->setIg([
 *     'id' => 12345
 *      'username' => frankeliuspoopie
 * ]);
 *
 * $user->getIg('name');
 * $user->getOption('foo');
 */

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

    // if $user->getOption is not found it will fall back to this
    protected $default_opts = [
        'fo' => 'this will always be included',
    ];

    private function setKeyValue($key, $value, array &$arr)
    {
        return $arr[$key] = $value;
    }

    private function getKeyValue($key, $attribute)
    {
        if ($attribute === 'option') {
            $attrs = array_merge($this->default_opts, $this->options);;
        } else {
            $attrs = $this->igAttrs;
        }
        return $attrs[$key];
    }

    public function setOption($key, $val) 
    {
        $dest = $this->options;
        $this->setKeyValue($key, $val, $dest);
        return $this->options = $dest;
    }

    public function setOptions(array $arr)
    {
        $dest = $this->options;
        foreach ($arr as $key => $value) {
            $this->setKeyValue($key, $value, $dest);
        }
        return $this->options = $dest;
    }

    public function getOption($key) 
    {
        return $this->getKeyValue($key, 'option');
    }

    public function getIg($key) 
    {
        return $this->getKeyValue($key, 'ig');
    }

    public function deleteOption($key) 
    {
        $arr = $this->options;
        unset($arr[$key]);
        return $this->options = $arr;
    }

    public function deleteOptions(array $arrKeys) 
    {
        $deletedArr = $this->options;
        foreach ($arrKeys as $key) {
            unset($deletedArr[$key]);
        }
        return $this->options = $deletedArr;
    }

    public function setIg($key, $value) 
    {
        $igAttrs = $this->igAttrs;
        if (!in_array($key, $this->igFields)) {
            // TODO - Custom exception?
            throw new \Exception('Can only set keys in igFields on igAttrs');
            return; // not needed?
        }
        $this->setKeyValue($key, $value, $igAttrs);
        return $this->igAttrs = $igAttrs;
    }

    public function setIgs(array $igAttrs) 
    {
        foreach ($igAttrs as $igKey => $igVal) {
            $this->setIg($igKey, $igVal);
        }
        return $this->igAttrs;
    }

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}