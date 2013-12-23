<?php namespace Anouar\Paypalpayment;

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
use PayPal\Api\Link;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\PaymentHistory;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Refund;
use PayPal\Api\Resource;
use PayPal\Api\Sale;
use PayPal\Api\ShippingAddress;
use PayPal\Api\SubTransaction;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalPayment{
  

    // Class functions

    public static function Address()
    {
        return new Address();
    }

    public static function Amount()
    {
        return new Amount();
    }

    public static function AmountDetails()
    {
        return new Details();
    }

    public static function Authorization()
    {
        return new Authorization();
    }

    public static function Capture()
    {
        return new Capture();
    }

    public static function CreditCard()
    {
        return new CreditCard();
    }

    public static function CreditCardToken()
    {
        return new CreditCardToken();
    }

    public static function FundingInstrument()
    {
        return new FundingInstrument();
    }

    public static function Item()
    {
        return new Item();
    }

    public static function ItemList()
    {
        return new ItemList();
    }

    public static function Link()
    {
        return new Link();
    }

    public static function Payee()
    {
        return new Payee();
    }

    public static function Payer()
    {
        return new Payer();
    }

    public static function PayerInfo()
    {
        return new PayerInfo();
    }

    public static function Payment()
    {
        return new Payment();
    }

    public static function PaymentExecution()
    {
        return new PaymentExecution();
    }

    public static function PaymentHistory()
    {
        return new PaymentHistory();
    }

    public static function RedirectUrls()
    {
        return new RedirectUrls();
    }

    public static function Refund()
    {
        return new Refund();
    }

    public static function Resource()
    {
        return new Resource();
    }

    public static function Sale()
    {
        return new Sale();
    }

    public static function ShippingAddress()
    {
        return new ShippingAddress();
    }

    public static function SubTransaction()
    {
        return new SubTransaction();
    }

    public static function Transaction()
    {
        return new Transaction();
    }


    public static function ApiContext($credential, $requestId=null)
    {
        return new ApiContext($credential, $requestId);
    }


    // Utilities functions

    public static function OAuthTokenCredential($ClientId=null,$ClientSecret=null)
    {
        define("PP_CONFIG_PATH", __DIR__);

        if(isset($ClientId) && isset($ClientSecret)) {
          return new OAuthTokenCredential($ClientId,$ClientSecret);
        }

        $configManager  = \PPConfigManager::getInstance();

        // $cred is used by samples that include this bootstrap file
        // This piece of code simply demonstrates how you can
        // dynamically pass in a client id/secret instead of using
        // the config file. If you do not need a way to pass
        // in credentials dynamically, you can skip the
        // <Resource>::setCredential($cred) calls that
        // you see in the samples.

        $cred =new OAuthTokenCredential(
            $configManager->get('acct1.ClientId'),
            $configManager->get('acct1.ClientSecret'));

        return $cred;
    }
 
    // utility functions that returns base url for
    public static function getBaseUrl()
    {
        return URL::to('/');
    }

    // grape payment details using the paymentId
    public static function get($paymentId, $apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::get($paymentId, $apiContext);
        }
        return Payment::get($paymentId);
    }

    // grape all payment details
    public static function all($param,$apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::all($param, $apiContext);
        }
        return Payment::all($param);
    }

}
