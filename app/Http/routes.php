<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Auth;

Route::get('/', function() {
    if(Auth::guest()) {
        return view('welcome');
    }
    else {
        return redirect()->action('HomeController@index');
    }
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/settings', 'HomeController@settings');
Route::get('/change-password', 'HomeController@changePassword');
Route::post('/update', 'HomeController@update');
Route::post('/new-status', 'HomeController@createStatus');

Route::get('/search', 'User\UserController@search');
Route::get('/viewUser/{username}', 'User\UserController@viewUser');
Route::get('/blocked-users', 'User\UserController@viewBlocked');
Route::post('/friend/{id}', 'User\UserController@FriendUser');
Route::post('/unfriend/{id}', 'User\UserController@removeFriendUser');
Route::post('/block/{id}', 'User\UserController@blockUser');
Route::post('/unblock/{id}', 'User\UserController@removeBlockUser');
Route::post('/search-users', 'User\UserController@searchUsers');

Route::get('/addresses', 'User\AddressController@addresses');
Route::get('/addresses/add', 'User\AddressController@add');
Route::get('/addresses/{id}', 'User\AddressController@edit');
Route::get('/addresses/delete/{id}', 'User\AddressController@remove');
Route::post('/addresses/create', 'User\AddressController@create');
Route::post('/addresses/update', 'User\AddressController@update');
Route::post('/addresses/delete', 'User\AddressController@delete');