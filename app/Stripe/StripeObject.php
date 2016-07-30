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
     * @var StripeProcessor
     */
    protected $processor;

    public function __construct()
    {
        parent::__construct();
        $this->processor = new StripeProcessor('pk_test_FVd5SLb2BCdSSiBK29QJ2uJ4', 'sk_test_X6eGWxYtNE9wiwitkAtUWSYE');
        $this->processor->connect();
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
        $this->_save();
        
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
    public function detokenize()
    {
        if(!empty($this->level)){}
        else if(empty($this->token)) {
            throw new Exception("StripeObject has no token: You can't delete a StripeObject that hasn't been
                                 saved to the API.");
        }

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
    public abstract function _save();

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
    public abstract function _delete();
}