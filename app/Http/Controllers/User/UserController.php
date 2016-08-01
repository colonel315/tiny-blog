<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * returns the search page with needed information.
     * 
     * @return $this
     */
    public function search()
    {
        $data = null;

        return view('user.search')->with('data', $data);
    }

    /**
     * Searches for the user using a full text search
     * returns the search users page with needed information.
     * 
     * @param Request $request
     * @return $this
     */
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
                              user_relationship.relationship_id IS NULL
                          ");

        return view('user.search')->with('data', $data);
    }

    /**
     * returns the users page with the needed information. 
     * If it is logged in users page returns home page. 
     * If it is a blocked user returns a 404 page.
     * 
     * @param $username
     * @return $this|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * returns the blocked users page with needed information.
     * 
     * @return $this
     */
    public function viewBlocked()
    {
        $blocked = Auth::user()->blockedUsers;

        return view('user.viewBlocked')->with('blocked', $blocked);
    }

    /**
     * Blocks the user the logged in user wants to block
     * 
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blockUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->addBlocked($user->id, $id);

        return back();
    }

    /**
     * Removes a blocked user from the database
     * 
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeBlockUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->removeBlocked($id);

        return back();
    }

    /**
     * Friends a user and adds the relationship to the database
     * 
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function friendUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->addFriend($user->id, $id);

        return back();
    }

    /**
     * removes a friend from the database
     * 
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFriendUser($id)
    {
        $user = User::find(Auth::user()->id);

        $user->removeFriend($id);

        return back();
    }
}