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
        'ig_attrs' => 'array',
        'options' => 'array',
        'access_token' => 'string',
    ];

    /**
     * All of the user's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'options' => '{}',
        'ig_attrs' => '{}',
        'access_token' => '',
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
            $attrs = $this->ig_attrs;
        }

        return isset($attrs[$key]) ? $attrs[$key] : null;
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
        return $this->options = $this->deleteKeyValue($arr, $key);
    }

    public function deleteOptions(array $arrKeys)
    {
        $optsArr = $this->options;
        foreach ($arrKeys as $key) {
            $this->deleteKeyValue($optsArr, $key);
        }
        return $this->options = $optsArr;
    }

    public function deleteIg($key)
    {
        $arr = $this->ig_attrs;
        return $this->ig_attrs = $this->deleteKeyValue($arr, $key);
    }

    public function deleteIgs(array $arrKeys)
    {
        $optsArr = $this->ig_attrs;
        foreach ($arrKeys as $key) {
            $this->deleteKeyValue($optsArr, $key);
        }
        return $this->ig_attrs = $optsArr;
    }

    private function deleteKeyValue(array &$arr, $key)
    {
        unset($arr[$key]);
        return $arr;
    }

    private function deleteKeys(array &$mutatedArray, array $keysToDelete)
    {
        foreach ($keysToDelete as $key) {
            $this->deleteKeyValue($mutatedArray, $key);
        }
        return $mutatedArray;
    }

    public function setIg($key, $value)
    {
        $ig_attrs = $this->ig_attrs;
        if (!in_array($key, $this->igFields)) {
            // TODO - Custom exception?
            throw new \Exception('Can only set keys in igFields on ig_attrs');
            return; // not needed?
        }
        $this->setKeyValue($key, $value, $ig_attrs);
        return $this->ig_attrs = $ig_attrs;
    }

    public function setIgs(array $ig_attrs)
    {
        foreach ($ig_attrs as $igKey => $igVal) {
            $this->setIg($igKey, $igVal);
        }
        return $this->ig_attrs;
    }

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }
}