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
        $user = \Auth::user();
        $this->setContext('home');
        $data = [
            'ig_attrs' => $user->ig_attrs,
        ];
        $client_data = [];

        if ($user->access_token) {
            $client_data['isAuthed'] = true;
        }
        JavaScript::put([
            'data' => $client_data,
        ]);
        return view('home', $data);
    }
}