<?php

namespace App;

use DateTime;
use Stripe;

class Subscription extends StripeObject
{
    /**
     * Items in array are able to be mass assigned
     *
     * @var array $fillable
     */
    protected $fillable = ['customer_id', 'plan_id', 'date_deleted', 'current_period_start', 'current_period_end',
                            'state'];

    /**
     * StripeCrud object that handles all crud functionality
     *
     * @var StripeCrud $crud
     */
    protected $crud;

    /**
     * Subscription constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->crud = new StripeCrud();
    }

    /**
     * Subscription has one plan
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plans()
    {
        return $this->hasOne(Plan::class);
    }

    /**
     * Subscription belongs to a customer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers()
    {
        return $this->belongsTo(Customer::class);
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
     * @return $this
     * @throws \Exception
     */
    public function _save()
    {
        // TODO: Implement _save() method.
        if(!empty($this->token)) {
            $subscription = Stripe\Subscription::retrieve($this->token);
            
            if(!$subscription) {
                throw new \Exception('Subscription {$this->token} doesn\'t exist');
            }
            
            $subscription = $this->crud->updateSubscription($subscription, $this);
            $subscription->save();
        }
        else {
            $subscription = $this->crud->saveSubscription($this);
            
            $this->status = $subscription->status;
            $this->token = $subscription->id;
        }

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
        
        $this->crud->deleteSubscription($this);
        $this->date_deleted = new DateTime;
        $this->state = 'CANCELED';
        $this->save();

        return $this;
    }
}
