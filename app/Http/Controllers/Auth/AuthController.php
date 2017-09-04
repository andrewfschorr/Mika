<?php

namespace App\Http\Controllers;

use JavaScript;
use Validator;
use App\Album;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $data = [];
    private $user;
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
    public function home(Request $request)
    {
        $this->setupData('home'); // this cant go in construct

        $this->dataBootstrap('home' , [
            'igUsername' => $this->user->is_ig_authed,
        ]);
        return view('home', $this->data);
    }

    public function editAlbum(Request $request, $user, $album)
    {
        $this->setupData('edit'); // this cant go in construct

        $album_name = sprintf('%1$s-%2$s', $this->user->getIg('username'), $album);
        $album_photos = $this->user->albums()->where('album_name', $album_name)->first();

        if (empty($this->user->is_ig_authed) || !$album_photos) {
            return redirect('/home');
        }

        $this->dataBootstrap('edit', [
            'album_photos' => $album_photos,
        ]);

        return view('edit', $this->data);
    }

    private function setupData($context)
    {
        $this->setContext($context);
        $this->user = \Auth::user();
        $this->data = [
            'is_ig_authed' => $this->user->is_ig_authed,
            'ig_attrs' => $this->user->ig_attrs,
            'albums' => $this->user->albums,
            'ig_username' => $this->user->getIg('username'),
        ];
    }
}