<?php

namespace App;

use Stripe;

/**
 * Created by PhpStorm.
 * User: Trey
 * Date: 7/25/2016
 * Time: 11:01 PM
 */
class StripeSave
{
    /**
     * @param User $user
     * @return Stripe\Customer
     */
    public function saveCustomer($user)
    {
        return Stripe\Customer::create(array(
            'description' => $user->id." ".$user->first_name.' '.$user->last_name,
            'email' => $user->email
        ));
    }

    public function saveCard($customer, $user, $card)
    {
        return $customer->sources->create(array("source" => [
            "object" => "card",
            "address_city" => $user->addresses[0]->city,
            "address_state" => $user->addresses[0]->state,
            "address_line1" => $user->addresses[0]->street,
            "address_zip" => $user->addresses[0]->zip,
            "exp_month" => $card->expiration_month,
            "exp_year" => $card->expiration_year,
            "number" => $card->number,
            "name" => $user->first_name." ".$user->last_name
        ]));
    }

    public function savePlan($plan)
    {
        return Stripe\Plan::create(array(
            "amount" => $plan->price,
            "interval" => $plan->interval,
            "name" => $plan->name,
            "currency" => "usd",
            'id' =>$plan->level
        ));
    }

    public function saveSubscription($subscription)
    {
        return Stripe\Subscription::create(array(
            'customer' => Stripe\Customer::retrieve(
                Customer::where('id', $subscription->customer_id)->first()->token
            ),
            'plan' => $subscription->plan_level
        ));
    }
}