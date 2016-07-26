<?php
/**
 * Created by PhpStorm.
 * User: Trey
 * Date: 7/21/2016
 * Time: 1:08 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentProcessorObject
 *
 * Describes an object that is returned from Stripe's API. You cannot create an instance of this class. You can
 * only extend from it. Notice that all of the classes below extend from this class.
 */
abstract class StripeObject extends Model
{
    /**
     * Every object returned from Stripe's API will have a unique token that you can use to identify it on Stripe's end.
     * This token can be used to update information about the payment object (such as a Card or Subscription), or
     * perform actions with it, like charging a payment, or cancelling a subscription.
     *
     * @var string
     */
    protected $token;
    /**
     * @var StripeProcessor
     */
    protected $processor;

    public function __construct()
    {
        $this->processor = new StripeProcessor('pk_test_FVd5SLb2BCdSSiBK29QJ2uJ4', 'sk_test_X6eGWxYtNE9wiwitkAtUWSYE');
        $this->processor->connect();
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Saves object from Stripe's API.
     *
     * When you want to save a card/subscription/customer or any other type of class that extends StripeObject,
     * you can just call this method. It is already complete, so you don't need to add anything to it.
     *
     * @return $this
     */
    public function tokenize()
    {
        if(!empty($this->token)) {
            return $this;
        }

        parent::save($this->toArray());
        
        return $this;
    }

    /**
     * Deletes object from Stripe's API.
     *
     * When you want to delete a card/subscription/customer or any other type of class that extends StripeObject,
     * you can just call this method. It is already complete, so you don't need to add anything to it.
     *
     * @return StripeObject
     * @throws Exception
     */
    public function delete()
    {
        if(empty($this->token)) {
            throw new Exception("StripeObject has no token: You can't delete a StripeObject that hasn't been
                                 saved to the API.");
        }

        parent::delete();
        
        return $this->_delete();
    }

    /**
     * Saves the current payment object to Stripe's API.
     *
     * Because this is an abstract function, every class that extends this class MUST have this function defined:
     *
     *      protected function _save() {
     *          //Logic to save the card/customer/subscription/etc here.
     *      }
     *
     * IMPORTANT: This only communicates with Stripe's API. It MUST not contain any database insert/update logic.
     *
     * @return $this
     */
    protected abstract function _save();

    /**
     * Deletes the current payment object from Stripe's API.
     *
     * Because this is an abstract function, every class that extends this class MUST have this function defined:
     *
     *      protected function _delete() {
     *          //Logic to save the card/customer/subscription/etc here.
     *      }
     *
     * IMPORTANT: This only communicates with Stripe's API. It MUST not contain any database delete logic.
     *
     * @return $this
     */
    protected abstract function _delete();
}