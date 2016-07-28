<?php
/**
 * Created by PhpStorm.
 * User: Trey
 * Date: 7/27/2016
 * Time: 8:44 PM
 */

namespace App;
use Stripe;

class StripeDelete
{
    public function deleteCustomer($customer)
    {
        $customer = Stripe\Customer::retrieve($customer->token);
        $customer->delete();
    }

    public function deleteCard($card)
    {
        $customer = Customer::find($card->customer_id);

        $stripeCus = Stripe\Customer::retrieve(Customer::where('id', $card->customer_id)->first()->token);

        $stripeCus->sources->retrieve($customer->cards->where('token', $card->token)->first()->token)->delete();
    }

    public function deleteSubscription($subscription)
    {
        Stripe\Subscription::retrieve($subscription->token)->cancel();
    }

    public function deletePlan($plan)
    {
        Stripe\Plan::retrieve($plan->level)->delete();
    }
}