<?php

namespace App\Http\Controllers\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search()
    {
        $data = null;

        return view('user.search')->with('data', $data);
    }

    public function searchUsers(Request $request)
    {
        $query = $request["query"];

        $userId = Auth::user()->id;

        $data = DB::select("
                            SELECT *,
                                MATCH (first_name, last_name) AGAINST ('" . $query . "') AS nscore,
                                MATCH (addresses.city, addresses.state) AGAINST ('" . $query . "') AS cscore
                            FROM users
                              LEFT JOIN addresses ON users.id = addresses.user_id
                              LEFT JOIN user_relationship ON users.id = user_relationship.user_id
                            WHERE
                              (MATCH (first_name, last_name) AGAINST ('" . $query . "')
                            OR
                              MATCH (addresses.city, addresses.state) AGAINST ('" . $query . "'))
                            AND
                              NOT users.id = " . $userId . "
                            AND
                              user_relationship.relationship_id IS NULL");

        return view('user.search')->with('data', $data);
    }

    public function viewUser($username)
    {
        if($username == Auth::user()->username) {
            return redirect()->to('/home');
        }

        $user = User::all()->where('username', $username)->first();

        if($user->userRelationships()->where('relationship_id', Auth::user()->id)->where('user_id', $user->id)->where('type', 'Block')->exists()) {
            abort(404, "unauthorized access");
        }

        $data = ['user' => $user, 'addresses' => $user->addresses];

        return view('user.viewUser')->with('data', $data);
    }

    public function viewBlocked()
    {
        $blocked = Auth::user()->blockedUsers;

        return view('user.viewBlocked')->with('blocked', $blocked);
    }

    public function blockUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->addBlocked($user->id, $id);

        return back();
    }

    public function removeBlockUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->removeBlocked($id);

        return back();
    }

    public function friendUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->addFriend($user->id, $id);

        return back();
    }

    public function removeFriendUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->removeFriend($id);

        return back();
    }
}