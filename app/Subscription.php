<?php

namespace App;

use Stripe;

class Subscription extends StripeObject
{
    protected $fillable = ['customer_id', 'plan_id', 'date_deleted', 'current_period_start', 'current_period_end', 
                            'state'];
    /** @var  int (foreign key) */
    protected $customer_id;
    /** @var  Plan (foreign key) */
    protected $plan;
    /** @var  DateTime */
    protected $date_created;
    /** @var  DateTime */
    protected $date_deleted;
    /**
     * Subscriptions are billed at an interval (monthly or yearly). This contains the start date of
     * the beginning of that interval. You can get this value through Stripe's "customer.subscription.updated"
     * web hook.
     *
     * @see https://stripe.com/docs/api#event_types (find "customer.subscription.updated")
     * @var  DateTime
     */
    protected $current_period_start;
    /**
     * Subscriptions are billed at an interval (monthly or yearly). This contains the start date of
     * the beginning of that interval. You can get this value through Stripe's "customer.subscription.updated"
     * web hook.
     *
     * @see https://stripe.com/docs/api#event_types (find "customer.subscription.updated")
     * @var  DateTime
     */
    protected $current_period_end;
    /**
     * Determines the state of the subscription.
     *
     * Possible values:
     *      ACTIVE - The subscription is active.
     *
     *      WAITING_ON_PAYMENT, - One or more of the subscription's invoices failed. After 3 failed invoices, the
     *                            state should be changed to DISABLED.
     *
     *      DISABLED - The subscription has been disabled becuase of too many failed invoice attempts.
     *                 (see invoice object below).
     *
     *      CANCELED - The subscription was cancelled by the user.
     *
     * @var string
     */
    protected $state;

    public function plans()
    {
        return $this->hasOne(Plan::class);
    }

    public function customers()
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param int $customer_id
     *
     * @return $this
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * @return Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param Plan $plan
     *
     * @return $this
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param DateTime $date_created
     *
     * @return $this
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateDeleted()
    {
        return $this->date_deleted;
    }

    /**
     * @param DateTime $date_deleted
     *
     * @return $this
     */
    public function setDateDeleted($date_deleted)
    {
        $this->date_deleted = $date_deleted;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCurrentPeriodStart()
    {
        return $this->current_period_start;
    }

    /**
     * @param DateTime $current_period_start
     *
     * @return $this
     */
    public function setCurrentPeriodStart($current_period_start)
    {
        $this->current_period_start = $current_period_start;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCurrentPeriodEnd()
    {
        return $this->current_period_end;
    }

    /**
     * @param DateTime $current_period_end
     *
     * @return $this
     */
    public function setCurrentPeriodEnd($current_period_end)
    {
        $this->current_period_end = $current_period_end;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
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
    protected function _save()
    {
        // TODO: Implement _save() method.
        $subscription = Stripe\Subscription::create(array(
           'customer' => $this->getCustomerId(),
            'plan' => $this->getPlan()->id
        ));

        $this->token = $subscription->getToken();
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
    protected function _delete()
    {
        // TODO: Implement _delete() method.
    }
}
