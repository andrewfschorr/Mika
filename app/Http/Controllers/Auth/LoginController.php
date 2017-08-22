<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\GuestController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Socialite;
use Validator;

class LoginController extends GuestController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'authInstagram', 'authInstagramCallback']]);
    }

        /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirect the user to the Ig authentication page.
     *
     * @return Response
     */
    public function authInstagram()
    {
        return Socialite::with('instagram')->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return Response
     */
    public function authInstagramCallback()
    {
        try {
            $igUser = Socialite::driver('instagram')->user();
        } catch (Exception $e) {
            return redirect('/'); // TODO Do something!
        }

        $validator = Validator::make(['ig_id' => $igUser->accessTokenResponseBody['user']['id']], [
            'ig_id' => 'required|unique:users',
        ], [
            'ig_id.unique' => 'Uh oh, it seems as if someone already connected this instagram to their account.',
        ]);

        if ($validator->fails()) {
            return redirect($this->redirectTo)->withErrors($validator, 'connect_ig');
        } else {
            $user = \Auth::user();
            $user->access_token = $igUser->accessTokenResponseBody['access_token'];
            $user->setIgs($igUser->accessTokenResponseBody['user']);
            $user->ig_id = $igUser->accessTokenResponseBody['user']['id'];
            $user->save();
            return redirect($this->redirectTo);
        }
    }


    public function showLoginForm()
    {
        $this->setContext('login');
        return view('auth.login');
    }
}
