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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/settings', 'User\UserController@settings');
Route::post('/update', 'User\UserController@update');

Route::get('/addresses', 'User\AddressController@addresses');
Route::get('/addresses/add', 'User\AddressController@add');
Route::get('/addresses/{id}', 'User\AddressController@edit');
Route::post('/addresses/create', 'User\AddressController@create');
Route::post('/addresses/update', 'User\AddressController@update');