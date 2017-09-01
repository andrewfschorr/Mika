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
        $this->setupData(); // this cant go in construct
        $this->setContext('home');

        // TODO put it it's own static method
        $this->dataBootstrap('home' , [
            'igUsername' => $this->user->is_ig_authed,
        ]);

        return view('home', $this->data);
        // This works too ¯\_(ツ)_/¯
        // TODO - Delete JS vendor pacakge if not needed?
        // JavaScript::put([
        //     'home' => [
        //         'client_data' => $client_data,
        //         'foo' => 'bar'
        //     ];
        // ]);
    }

    public function editAlbum(Request $request, $user, $album)
    {
        $this->setupData(); // this cant go in construct
        if (empty($this->user->is_ig_authed)) {
            return redirect('/home');
        }
        echo 'yolo';
        return view('edit', $this->data);
    }

    private function setupData()
    {
        $this->user = \Auth::user();
        $this->data = [
            'is_ig_authed' => $this->user->is_ig_authed,
            'ig_attrs' => $this->user->ig_attrs,
            'albums' => $this->user->albums,
            'ig_username' => $this->user->getIg('username'),
        ];
    }
}