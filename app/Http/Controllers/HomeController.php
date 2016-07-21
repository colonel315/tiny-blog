<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return $this->validate($request, ['password' => 'required|min:6|confirmed',]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        $statuses = Status::join('users', 'users.id', '=', 'statuses.user_id')
        //                            ->whereIn('statuses.user_id', function($query) {
        //                                $query->select('user_relationship.relationship_id')
        //                                ->from('user_relationship')
        //                                ->where('user_relationship.relationship_id', 'statuses.user_id');
        //                            })
        //                            ->orWhere('statuses.user_id', Auth::user()->id)
        //                            ->orderBy('statuses.created_at', 'DESC')->get();
        //
        //        return dd($statuses);

        $statuses = DB::select("SELECT *
                                FROM
                                  statuses
                                    INNER JOIN users ON users.id = statuses.user_id
                                WHERE
                                    statuses.user_id IN (
                                      SELECT
                                        user_relationship.relationship_id
                                      FROM
                                        user_relationship
                                      WHERE
                                        user_relationship.relationship_id = statuses.user_id
                                      AND 
                                        user_relationship.type = 'Friend'
                                    )
                                  OR
                                    statuses.user_id =" . Auth::user()->id . "
                                ORDER BY
                                  statuses.created_at DESC");

        return view('home')->with('statuses', $statuses);
    }

    public function createStatus(Request $request)
    {
        $user = Auth::user();

        $user->addStatus($request->status);

        return redirect()->action('HomeController@index');
    }

    public function settings()
    {
        $user = Auth::user();

        $data = ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'username' => $user->username, 'email' => $user->email, 'high_school' => $user->high_school, 'description' => $user->description,];

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
}
