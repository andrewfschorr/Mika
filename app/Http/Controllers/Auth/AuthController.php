<?php

namespace App\Http\Controllers;

use JavaScript;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Home page inacessable if logged IN
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $this->setContext('test');

        JavaScript::put(['foo' => 'bar']);

        $data = [
            'ig_attrs' => \Auth::user()->ig_attrs,
        ];
        return view('home', $data);
    }
}