<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Stripe;

class Card extends StripeObject
{
    protected $fillable = ['customer_id', 'number', 'expiration_month', 'expiration_year'];

    protected $saver;
    protected $deleter;

    public function __construct()
    {
        parent::__construct();
        $this->saver = new StripeSave();
        $this->deleter = new StripeDelete();
    }
    /**
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
     *
     * @return $this
     */
    public function _save()
    {
        // TODO: Implement _save() method.
        $user = User::find(1);

        $customer = Stripe\Customer::retrieve(
            Customer::where('user_id', $user->id)->first()->token
        );

        $card = $this->saver->saveCard($customer, $user, $this);

        $this->token = $card->id;
        
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
        $this->deleter->deleteCard($this);
        return $this;
    }
}