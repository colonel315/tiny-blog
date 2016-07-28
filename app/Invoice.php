<?php

namespace App;

use Stripe;

class Invoice extends StripeObject
{
    protected $fillable = ['customer_id', 'subscription_id', 'amount', 'last_date_attempted', 'attempt_count', 
                            'receipt_number', 'status'];
    
    protected $saver;

    public function __construct()
    {
        parent::__construct();
        $this->saver = new StripeSave();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscriptions()
    {
        return $this->belongsTo(Subscription::class);
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

        $this->status = 'Active';
        
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
    }
}
