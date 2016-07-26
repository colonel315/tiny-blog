<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;

class SubscriptionController extends Controller
{
    public function signUpSubmit()
    {
        $user = Auth::user();

        $customer = new Customer();
        $customer->setUserId($user->id);
        
        $customer->save();
    }
}