<?php

namespace App;

use Stripe;

class Plan extends StripeObject
{
    protected $fillable = ['name', 'price', 'interval'];
    
    protected $crud;

    public function __construct()
    {
        parent::__construct();
        $this->crud = new StripeCrud();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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
        if(!empty($this->id)) {
            $plan = Stripe\Plan::retrieve($this->level);

            if(!$plan) {
                throw new \Exception('Plan {$this->level} doesn\'t exist');
            }

            $plan = $this->crud->updatePlan($plan, $this);
            $plan->save();
        }
        else {
            $this->crud->savePlan($this);
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
        $this->crud->deletePlan($this);
        return $this;
    }
}
