<?php namespace Anouar\Paypalpayment;

use Illuminate\Support\Facades\URL;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Links;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\PaymentHistory;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Refund;
use PayPal\Api\RelatedResources;
use PayPal\Api\Sale;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Api\Transactions;
use PayPal\Core\PPConfigManager;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalPayment{


    /**
     * @return Paypal\Api\Address
     */
    public function address()
    {
        return new Address;
    }

    /**
     * @return Paypal\Api\Amount
     */
    public function amount()
    {
        return new Amount;
    }

    /**
     * @return Paypal\Api\Details
     */
    public  function details()
    {
        return new Details;
    }

    /**
     * @return Paypal\Api\Authorization
     */
    public  function authorization()
    {
        return new Authorization;
    }

    /**
     * @return Paypal\Api\Capture
     */
    public  function capture()
    {
        return new Capture;
    }

    /**
     * @return Paypal\Api\CreditCard
     */
    public  function creditCard()
    {
        return new CreditCard;
    }

    /**
     * @return Paypal\Api\CreditCardToken
     */
    public  function creditCardToken()
    {
        return new CreditCardToken;
    }

    /**
     * @return Paypal\Api\FundingInstrument
     */
    public  function fundingInstrument()
    {
        return new FundingInstrument;
    }

    /**
     * @return Paypal\Api\Item
     */
    public  function item()
    {
        return new Item;
    }

    /**
     * @return Paypal\Api\ItemList
     */
    public  function itemList()
    {
        return new ItemList;
    }

    /**
     * @return Paypal\Api\Links
     */
    public  function links()
    {
        return new Links;
    }

    /**
     * @return Paypal\Api\Payee
     */
    public  function payee()
    {
        return new Payee;
    }

    /**
     * @return Paypal\Api\Payer
     */
    public  function payer()
    {
        return new Payer;
    }

    /**
     * @return Paypal\Api\PayerInfo
     */
    public  function payerInfo()
    {
        return new PayerInfo;
    }

    /**
     * @return Paypal\Api\Payment
     */
    public  function payment()
    {
        return new Payment;
    }

    /**
     * @return Paypal\Api\PaymentExecution
     */
    public  function paymentExecution()
    {
        return new PaymentExecution;
    }

    /**
     * @return Paypal\Api\PaymentHistory
     */
    public  function paymentHistory()
    {
        return new PaymentHistory;
    }

    /**
     * @return Paypal\Api\RedirectUrls
     */
    public  function redirectUrls()
    {
        return new RedirectUrls;
    }

    /**
     * @return Paypal\Api\Refund
     */
    public  function refund()
    {
        return new Refund;
    }

    /**
     * @return Paypal\Api\RelatedResources
     */
    public  function relatedResources()
    {
        return new RelatedResources;
    }

    /**
     * @return Paypal\Api\Sale
     */
    public  function sale()
    {
        return new Sale;
    }

    /**
     * @return Paypal\Api\ShippingAddress
     */
    public  function shippingAddress()
    {
        return new ShippingAddress;
    }

    /**
     * @return Paypal\Api\Transactions
     */
    public  function transactions()
    {
        return new Transactions;
    }

    /**
     * @return Paypal\Api\Transaction
     */
    public function transaction()
    {
        return new Transaction;
    }


    /**
     * @param null $clientId
     * @param null $clientSecret
     * @param null $requestId
     * @return Paypal\Rest\ApiContext
     */
    public function apiContext($clientId = null, $clientSecret = null, $requestId = null)
    {
        $credentials = self::OAuthTokenCredential($clientId, $clientSecret);

        return new ApiContext($credentials, $requestId);
    }

    /**
     * @param null $ClientId
     * @param null $ClientSecret
     * @return PayPal/Auth/OAuthTokenCredential
     */
    public  static function OAuthTokenCredential($ClientId = null, $ClientSecret=null)
    {
        //define("PP_CONFIG_PATH", __DIR__);

        if(isset($ClientId) && isset($ClientSecret)) {
          return new OAuthTokenCredential($ClientId, $ClientSecret);
        }

        $configManager  = PPConfigManager::getInstance();
        // $cred is used by samples that include this bootstrap file
        // This piece of code simply demonstrates how you can
        // dynamically pass in a client id/secret instead of using
        // the config file. If you do not need a way to pass
        // in credentials dynamically, you can skip the
        // <Resource>::setCredential($cred) calls that
        // you see in the samples.

        $cred = new OAuthTokenCredential(
            $configManager->get('acct1.ClientId'),
            $configManager->get('acct1.ClientSecret'));

        return $cred;
    }
 
    /**
     * Get the base URL
     * @return mixed
     */
    public function getBaseUrl()
    {
        return URL::to('/');
    }

    /**
     * grape payment details using the paymentId
     * @param $paymentId
     * @param null $apiContext
     * @return Paypal\Api\Payment
     */
    public static function getById($paymentId, $apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::get($paymentId, $apiContext);
        }
        return Payment::get($paymentId);
    }

    /**
     * grape all payment details
     * @param $param
     * @param null $apiContext
     * @return Paypal\Api\Payment
     */
    public static function getAll($param, $apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::all($param, $apiContext);
        }
        return Payment::all($param);
    }

}
