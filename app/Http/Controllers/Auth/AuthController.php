<?php

namespace App\Http\Controllers;

use JavaScript;
use Validator;
use App\Album;
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
            'ig_username' => $user->getIg('username')
        ];
        return view('home', $data);
        // $this->dataBootstrap('home' , [
        //     'foo' => 'bar',
        // ]);

        // This works too ¯\_(ツ)_/¯
        // TODO - Delete if not needed?
        // JavaScript::put([
        //     'home' => [
        //         'client_data' => $client_data,
        //         'foo' => 'bar'
        //     ];
        // ]);
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

        $data = compact('images', 'album_name', 'display_name');

        $validator = Validator::make(
            $data,
            [
                'album_name' => 'required|unique:albums',
                'images' => 'present|array',
            ],
            [
                // because ajax, don't think these are in use
                'album_name.unique' => 'Uh oh, Somethings up... Our engineers have been alerted :/',
                'images' => 'Uh oh, Somethings up... Our engineers have been alerted :/',
            ]
        );

        if ($validator->fails()) {
            // TODO return error code and flash error message on front end
            // return redirect('/')->withErrors($validator, 'make_album');
        } else {
            try {
                Album::create([
                    'album_name' => $data['album_name'],
                    'display_name' => $data['display_name'],
                    'images' => $data['images'],
                    'user_id' => $user->id,
                ]);
            } catch (\Illuminate\Database\QueryException $exception) {
                // TODO return error code and flash error message on front end
            }
        }
    }
}