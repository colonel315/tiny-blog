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
     * Saves the customer onto stripe
     * 
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

    /**
     * Deletes the stripe customer
     * 
     * @param $customer
     */
    public function deleteCustomer($customer)
    {
        Stripe\Customer::retrieve($customer->token)->delete();
    }

    /**
     * Updates the stripe customer to be saved
     *
     * @param $oldCustomer
     * @param $newCustomer
     * @return mixed
     */
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

    /**
     * Saves the card onto stripe
     *
     * @param $customer
     * @param $user
     * @param $card
     * @return mixed
     */
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

    /**
     * Deletes the card from stripe
     *
     * @param $card
     */
    public function deleteCard($card)
    {
        $customer = Customer::find($card->customer_id);

        $stripeCus = Stripe\Customer::retrieve(Customer::where('id', $card->customer_id)->first()->token);

        $stripeCus->sources->retrieve($customer->cards->where('token', $card->token)->first()->token)->delete();
    }

    /**
     * Updates the stripe card to be saved
     *
     * @param $oldCard
     * @param $newCard
     * @return mixed
     */
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

    /**
     * Save the plan onto stripe
     *
     * @param $plan
     * @return Stripe\Plan
     */
    public function savePlan($plan)
    {
        return Stripe\Plan::create(array(
            "amount" => $plan->price,
            "interval" => $plan->interval,
            "name" => $plan->name,
            "currency" => "usd",
            'id' => $plan->level
        ));
    }

    /**
     * Deletes the plan on stripe
     *
     * @param $plan
     */
    public function deletePlan($plan)
    {
        Stripe\Plan::retrieve($plan->level)->delete();
    }

    /**
     * Updates the stripe plan to be saved.
     *
     * @param $oldPlan
     * @param $newPlan
     * @return mixed
     */
    public function updatePlan($oldPlan, $newPlan)
    {
        $oldPlan->name = $newPlan->name;

        return $oldPlan;
    }

    /**
     * Saves the subscription onto stripe
     *
     * @param $subscription
     * @return Stripe\Subscription
     */
    public function saveSubscription($subscription)
    {
        return Stripe\Subscription::create(array(
            'customer' => Stripe\Customer::retrieve(
                Customer::where('id', $subscription->customer_id)->first()->token
            ),
            'plan' => $subscription->plan_level
        ));
    }

    /**
     *
     * cancels the subscription on stripe
     * @param $subscription
     */
    public function deleteSubscription($subscription)
    {
        Stripe\Subscription::retrieve($subscription->token)->cancel();
    }


    /**
     * updates stripe subscription to be saved.
     *
     * @param $oldSubscription
     * @param $newSubscription
     * @return mixed
     */
    public function updateSubscription($oldSubscription, $newSubscription)
    {
        $oldSubscription->plan = $newSubscription->plan_level;

        return $oldSubscription;
    }
}