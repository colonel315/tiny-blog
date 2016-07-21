<?php

namespace App;

class Card extends StripeObject
{
    /** @var  Customer (foreign key) */
    protected $customer_id;
    /**
     * The credit card's number.
     *
     * If the card is new, this should store the full 12 digit number. After it has been saved to stripe,
     * it should only store the last 4 digits of the number.
     *
     * @var  int
     */
    protected $number;
    /**
     * Integer representation of a month. (1 = Jan, 12 = Dec).
     *
     * @var  int
     */
    protected $expiration_month;
    /**
     * 4 digit year.
     *
     * @var int
     */
    protected $expiration_year;

    /**
     * @return Customer
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param Customer $customer_id
     *
     * @return $this
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationMonth()
    {
        return $this->expiration_month;
    }

    /**
     * @param int $expiration_month
     *
     * @return $this
     */
    public function setExpirationMonth($expiration_month)
    {
        $this->expiration_month = $expiration_month;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationYear()
    {
        return $this->expiration_year;
    }

    /**
     * @param int $expiration_year
     *
     * @return $this
     */
    public function setExpirationYear($expiration_year)
    {
        $this->expiration_year = $expiration_year;

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
