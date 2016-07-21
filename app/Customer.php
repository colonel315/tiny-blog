<?php

namespace App;

class Customer extends StripeObject
{
    /** @var  User (foreign key) */
    protected $user_id;
    /**
     * An array of Card objects. (many cards to one customer relationship)
     *
     * @var Card[]
     */
    protected $cards;
    /**
     * One-to-one relationship with Subscription object. In this relationship, the subscription should be accessible
     * from this object, but the customer ID should be stored in the subscription object.
     *
     * @var Subscription
     */
    protected $subscription;

    /**
     * @return User
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param User $user_id
     *
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Card[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param Card[] $cards
     *
     * @return $this
     */
    public function setCards($cards)
    {
        $this->cards = $cards;

        return $this;
    }

    /**
     * @return Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param Subscription $subscription
     *
     * @return $this
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;

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
