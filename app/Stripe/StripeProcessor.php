<?php
/**
 * Created by PhpStorm.
 * User: Trey
 * Date: 7/21/2016
 * Time: 1:06 PM
 */

namespace App;

use Stripe\Stripe;

/**
 * Class Stripe
 *
 * This class is complete. You don't have to change anything. If you get an error saying that Stripe could not be
 * found, make sure that you have a 'use' statement at the top of this class file to import Stripe's namespace.
 *
 * IMPORTANT: This class is not an entity that you save to the database. It's more of a helper class.
 */
class StripeProcessor
{
    /**
     * The public API key for your Stripe account.
     *
     * @var  string
     */
    protected $publicApiKey;
    /**
     * The secret API key for your stripe account.
     *
     * @var string
     */
    protected $secretApiKey;
    /** @var  bool */
    private $isConnected;

    /**
     * StripeProcessor constructor.
     *
     * @param $publicKey
     * @param $secretKey
     */
    public function __construct($publicKey, $secretKey)
    {
        $this->publicApiKey = $publicKey;
        $this->secretApiKey = $secretKey;
        $this->isConnected = false;
    }

    /**
     * Connect to Stripe's API.
     *
     * This is where you set your API keys.
     */
    public function connect()
    {
        try {
            if($this->isConnected) {
                return null;
            }
            Stripe::setApiKey($this->secretApiKey);
            $this->isConnected = true;
        } catch(StripeApiException $e) {
            //Stripe's API is down/unavailable.
            throw new Exception("Sorry, our payment processor is unavailable at this time.", $e->getCode(), $e);
        } catch(\Exception $e) {
            //Failed to send the request to connect to Stripe.
            throw new Exception("Sorry, an error occurred while attempting to connect to our payment processor", $e->getCode(), $e);
        }
    }
}