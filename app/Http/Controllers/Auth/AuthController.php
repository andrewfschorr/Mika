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
            'albums' => $user->albums,
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

    public function makeAlbum(Request $request)
    {
        $user = \Auth::user();
        $images = [];
        foreach ($request->input('imgs') as $image) {
            if (strpos($image, 'cdninstagram.com')) {
                $images[] = $image;
            }
        }

        $name = $request->input('name');
        $album_name = $user->name . '-' . strtolower($name);
        $display_name = $name;

        \Log::info($images);
        \Log::info($album_name);
        \Log::info($display_name);

        // return Album::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => bcrypt($data['password']),
        // ]);

        // $validator = Validator::make(['ig_id' => $igUser->accessTokenResponseBody['user']['id']], [
        //     'ig_id' => 'required|unique:users',
        // ], [
        //     'ig_id.unique' => 'Uh oh, it seems as if someone already connected this instagram to their account.',
        // ]);

        // if ($validator->fails()) {
        //     return redirect($this->redirectTo)->withErrors($validator, 'connect_ig');
        // } else {
        //     $user = \Auth::user();
        //     $user->access_token = $igUser->accessTokenResponseBody['access_token'];
        //     $user->setIgs($igUser->accessTokenResponseBody['user']);
        //     $user->ig_id = $igUser->accessTokenResponseBody['user']['id'];
        //     $user->save();
        //     return redirect($this->redirectTo);
        // }
    }
}