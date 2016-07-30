<?php

namespace App;

use Stripe;
use DateTime;

/**
 * Created by PhpStorm.
 * User: Trey
 * Date: 7/25/2016
 * Time: 11:01 PM
 */
class StripeCrud
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

    public function deleteCustomer($customer)
    {
        $customer = Stripe\Customer::retrieve($customer->token);
        $customer->delete();
    }

    public function updateCustomer($oldCustomer, $newCustomer)
    {
        if(!empty($newCustomer->description)) {
            $oldCustomer->description = $newCustomer->description;
        }
        if(!empty($newCustomer->email)) {
            $oldCustomer->email = $newCustomer->email;
        }

        return $oldCustomer;
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

    public function deleteCard($card)
    {
        $customer = Customer::find($card->customer_id);

        $stripeCus = Stripe\Customer::retrieve(Customer::where('id', $card->customer_id)->first()->token);

        $stripeCus->sources->retrieve($customer->cards->where('token', $card->token)->first()->token)->delete();
    }

    public function updateCard($oldCard, $newCard)
    {
        $oldCard->address_city = $newCard->address_city;
        $oldCard->address_line1 = $newCard->address_line1;
        $oldCard->address_line2 = $newCard->address_line2;
        $oldCard->address_state = $newCard->address_state;
        $oldCard->address_zip = $newCard->address_zip;
        $oldCard->exp_month = $newCard->exp_month;
        $oldCard->exp_year = $newCard->exp_year;
        $oldCard->name = $newCard->name;

        return $oldCard;
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

    public function deletePlan($plan)
    {
        Stripe\Plan::retrieve($plan->level)->delete();
    }

    public function updatePlan($oldPlan, $newPlan)
    {
        $oldPlan->name = $newPlan->name;

        return $oldPlan;
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

    public function deleteSubscription($subscription)
    {
        Stripe\Subscription::retrieve($subscription->token)->cancel();
    }

    public function updateSubscription($oldSubscription, $newSubscription)
    {
        $oldSubscription->plan = $newSubscription->plan_level;

        return $oldSubscription;
    }
}