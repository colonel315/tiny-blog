<?php

namespace App;

use Stripe;

class Customer extends StripeObject
{
    protected $fillable = ['user_id'];
    
    protected $saver;
    protected $deleter;
    
    /**
     * Customer constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->saver = new StripeSave();
        $this->deleter = new StripeDelete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function users()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscriptions()
    {
        return $this->hasOne(Subscription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
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
        $user = User::find($this->user_id);

        $customer = $this->saver->saveCustomer($user);

        $this->token = $customer->id;

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
        $this->deleter->deleteCustomer($this);
        return $this;
    }
}
