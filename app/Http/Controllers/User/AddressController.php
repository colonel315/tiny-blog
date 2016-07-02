<?php

namespace App\Http\Controllers\User;

use App\Address;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:6|confirmed'
        ]);
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses;
        
        return view('address.address')->with(['addresses' => $addresses]);
    }

    public function edit($addressId)
    {
        $address = Auth::user()->addresses()->where('id', $addressId)->first();

        return view('address.editAddress')->with('address', $address);
    }

    public function update(Request $request)
    {
        $address = Auth::user()->addresses()->where('id', $request->addressId)->first();

        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip = $request->zip;

        $address->save();

        return redirect()->action('User\addressController@addresses');
    }

    public function add()
    {
        return view('address.addAddress');
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        $address = new Address;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->zip = $request->zip;

        $user->addAddress($address, $user->id);

        return redirect()->action('User\AddressController@addresses');
    }

    public function remove($addressId) {
        $address = Auth::user()->addresses()->where('id', $addressId)->first();

        return view('address.deleteAddress')->with('address', $address);
    }
    
    public function delete(Request $request) {
        $user = Auth::user();

        $user->addresses()->where('id', $request->addressId)->delete();
        
        return redirect()->action('User\AddressController@addresses');
    }
}
