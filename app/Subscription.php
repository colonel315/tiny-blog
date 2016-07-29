<?php

namespace App;

use DateTime;
use Stripe;

class Subscription extends StripeObject
{
    protected $fillable = ['customer_id', 'plan_id', 'date_deleted', 'current_period_start', 'current_period_end',
                            'state'];

    protected $saver;
    protected $deleter;

    /**
     * Subscription constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->saver = new StripeSave();
        $this->deleter = new StripeDelete();
    }

    public function plans()
    {
        return $this->hasOne(Plan::class);
    }

    public function customers()
    {
        return $this->hasOne(Customer::class);
    }
    
    /**
     * Saves the current payment object to Stripe's API.
     *
     * Because this is an function, every class that extends this class MUST have this function defined:
     *
     *      protected function _save() {
     *          //Logic to save the card/customer/subscription/etc here.
     *      }
     *
     * IMPORTANT: This only communicates with Stripe's API. It MUST not contain any database insert/update logic.
     *
     * @return $this
     */
    public function _save()
    {
        // TODO: Implement _save() method.
        $subscription = $this->saver->saveSubscription($this);

        $this->token = $subscription->id;

        return $this;
    }

    /**
     * Deletes the current payment object from Stripe's API.
     *
     * Because this is an function, every class that extends this class MUST have this function defined:
     *
     *      protected function _delete() {
     *          //Logic to save the card/customer/subscription/etc here.
     *      }
     *
     * IMPORTANT: This only communicates with Stripe's API. It MUST not contain any database delete logic.
     *
     * @return $this
     */
    public function _delete()
    {
        // TODO: Implement _delete() method.
        
        $this->deleter->deleteSubscription($this);
        $this->date_deleted = new DateTime;
        $this->state = 'CANCELED';
        $this->save();

        return $this;
    }
}
