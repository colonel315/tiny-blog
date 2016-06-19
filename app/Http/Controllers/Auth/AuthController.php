<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Address;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
        $this->sendEmail($data);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'description' => $data['description'],
            'high_school' => $data['high_school'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);

        $address = new Address;
        $address->street = $data['street'];
        $address->city = $data['city'];
        $address->state = $data['state'];
        $address->zip = $data['zip'];
        
        $user->addAddress($address, $user->id);

        return $user;
    }

    protected function sendEmail(array $data)
    {
        $viewData = [
            'name' => $data['name'],
            'password' => $data['password']
        ];

        Mail::send('emails.welcome', $data, function ($m) use ($data) {
            $m->to($data['email'], $data['name'])->subject("Welcome!");
        });
    }
}
