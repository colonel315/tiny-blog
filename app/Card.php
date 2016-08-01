<?php

namespace App;

use Stripe;

class Card extends StripeObject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = ['customer_id', 'number', 'expiration_month', 'expiration_year'];

    /**
     * StripeCrud object that handles all crud functionality
     *
     * @var StripeCrud $crud
     */
    protected $crud;

    public function __construct()
    {
        parent::__construct();
        $this->crud = new StripeCrud();
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
     * @return $this $ this
     * @throws \Exception
     */
    public function _save()
    {
        // TODO: Implement _save() method.
        $user = User::find(
            Customer::find($this->customer_id)->user_id
        );

        $customer = Stripe\Customer::retrieve(
            Customer::find($this->customer_id)->first()->token
        );

        if(!$customer) {
            throw new \Exception('Customer has not been saved to Stripe');
        }
        
        if(!empty($this->token)) {
            $card = $customer->sources->retrieve($this->token);
            
            if(!$card) {
                throw new \Exception('customer card {$this->token} doesn\'t exist');
            }
            
            $card = $this->crud->updateCard($card, $this);
            
            $card->save();
        }
        else {
            $card = $this->crud->saveCard($customer, $user, $this);

            $this->token = $card->id;
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
        $this->crud->deleteCard($this);
        return $this;
    }
}