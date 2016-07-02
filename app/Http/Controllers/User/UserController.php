<?php

namespace App\Http\Controllers\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function settings()
    {
        $user = Auth::user();

        $data = [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
            'high_school' => $user->high_school,
            'description' => $user->description,
        ];

        return view('user.settings')->with('data', $data);
    }

    public function changePassword()
    {
        return view('user.changePassword');
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        if(!is_null($request->first_name)) {
            $user->first_name = $request->first_name;
        }
        elseif(!is_null($request->last_name)) {
            $user->last_name = $request->last_name;
        }
        elseif(!is_null($request->username)) {
            $user->username = $request->username;
        }
        elseif(!is_null($request->email)) {
            $user->email = $request->email;
        }
        elseif(!is_null($request->high_school)) {
            $user->high_school = $request->high_school;
        }
        elseif(!is_null($request->description)) {
            $user->description = $request->description;
        }
        elseif(!is_null($request->password) && !is_null($request->password_confirmation)) {
            $this->validator($request);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back();
    }

    public function search()
    {
        $data = null;
        return view('user.search')->with('data', $data);
    }

    public function searchUsers(Request $request)
    {
        $query = $request["query"];

        $data = DB::select("SELECT *, 
                              MATCH (first_name, last_name) AGAINST ('".$query."') AS nscore, 
                              MATCH (addresses.city, addresses.state) AGAINST ('".$query."') AS cscore 
                          FROM users 
                            JOIN addresses ON users.id=addresses.user_id 
                          WHERE 
                            MATCH (first_name, last_name) AGAINST ('".$query."')
                          OR 
                            MATCH (addresses.city, addresses.state) AGAINST ('".$query."') 
                          ORDER BY nscore + cscore DESC");

        return view('user.search')->with('data', $data);
    }
}
