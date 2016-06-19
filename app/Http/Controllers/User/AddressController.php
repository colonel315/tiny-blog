<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addresses()
    {
        $addresses = Auth::user()->addresses;
        
        return view('user.address')->with(['addresses' => $addresses]);
    }

    public function show($addressId)
    {
        $address = Auth::user()->addresses()->where('id', $addressId)->first();

        return view('user.showAddress')->with('address', $address);
    }

    public function update(Request $request)
    {
        $address = Auth::user()->addresses()->where('id', $request->addressId)->first();

        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip = $request->zip;

        $address->save();

        return redirect()->action('User\UserController@settings');
    }
}
