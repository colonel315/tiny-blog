<?php

namespace App;

use Stripe;

class Invoice extends StripeObject
{
    protected $fillable = ['customer_id', 'subscription_id', 'amount', 'last_date_attempted', 'attempt_count', 
                            'receipt_number', 'status'];
    /** @var  Customer (foreign key) */
    protected $customer_id;
    /** @var  Subscription (foreign key) */
    protected $subscription_id;
    /**
     * The amount charged in cents.
     *
     * If the user was charged $5, this value should be 500.
     * @var  int
     */
    protected $amount;
    /**
     * The date the invoice was created. This is not always the date it was charged. Sometimes,
     * invoices are created, but fail the first time and are successful on the second or third attempt a
     * few days later.
     *
     * @var  DateTime
     */
    protected $date_created;
    /**
     * The date/time the invoice was attempted.
     *
     * @var DateTime
     */
    protected $last_date_attempted;
    /**
     * If an invoice fails to successfully charge the customer's card (like if they don't have enough funds in their
     * bank account), it will attempt to charge the account again. This will keep track of how many times Stripe
     * attempted to charge the account.
     *
     * After 3 failed attempts, you should change the subscription's status to DISABLED.
     *
     * @var int
     */
    protected $attempt_count;
    /**
     * The receipt number for this invoice. Stripe's API will give this to you.
     *
     * @var  string
     */
    protected $receipt_number;
    /**
     * Tells us whether or not the charge was successful.
     *
     * Possible values: PAID, PENDING, FAILED.
     *
     * @var string
     */
    protected $status;

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
     * @return Subscription
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * @param Subscription $subscription_id
     *
     * @return $this
     */
    public function setSubscriptionId($subscription_id)
    {
        $this->subscription_id = $subscription_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

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
    public function getLastDateAttempted()
    {
        return $this->last_date_attempted;
    }

    /**
     * @param DateTime $last_date_attempted
     *
     * @return $this
     */
    public function setLastDateAttempted($last_date_attempted)
    {
        $this->last_date_attempted = $last_date_attempted;

        return $this;
    }

    /**
     * @return int
     */
    public function getAttemptCount()
    {
        return $this->attempt_count;
    }

    /**
     * @param int $attempt_count
     *
     * @return $this
     */
    public function setAttemptCount($attempt_count)
    {
        $this->attempt_count = $attempt_count;

        return $this;
    }

    /**
     * @return string
     */
    public function getReceiptNumber()
    {
        return $this->receipt_number;
    }

    /**
     * @param string $receipt_number
     *
     * @return $this
     */
    public function setReceiptNumber($receipt_number)
    {
        $this->receipt_number = $receipt_number;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

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

        $invoice = Stripe\Invoice::create(array(
            "customer" => $this->getCustomerId(),
            "subscription" => $this->getSubscriptionId()
        ));

        $this->token = $invoice->getToken();

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
    protected function _delete()
    {
        // TODO: Implement _delete() method.
    }
}
