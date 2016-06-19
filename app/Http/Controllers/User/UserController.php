<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function settings()
    {
        $user = Auth::user();

        $data = [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'high_school' => $user->high_school,
            'description' => $user->description,
        ];

        return view('user.settings')->with('data', $data);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if(!is_null($request->name)) {
            $user->name = $request->name;
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
        elseif(!is_null($request->new_password)) {
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return back();
    }
}
