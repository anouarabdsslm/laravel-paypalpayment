<?php

namespace Anouar\Paypalpayment;

use Illuminate\Support\Facades\URL;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\CreditCard;
use PayPal\Api\CreditCardToken;
use PayPal\Api\Details;
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
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Core\PPConfigManager;
use PayPal\Rest\ApiContext;

/**
 * Class PaypalPayment
 *
 * @package Anouar\Paypalpayment
 */
class PaypalPayment
{

    /**
     * @param null | string $clientId
     * @param null | string $clientSecret
     *
     * @return OAuthTokenCredential
     */
    public static function OAuthTokenCredential($clientId = null, $clientSecret = null)
    {
        if (isset($clientId, $clientSecret)) {
            return new OAuthTokenCredential($clientId, $clientSecret);
        }

        $configManager = PPConfigManager::getInstance();
        // $cred is used by samples that include this bootstrap file
        // This piece of code simply demonstrates how you can
        // dynamically pass in a client id/secret instead of using
        // the config file. If you do not need a way to pass
        // in credentials dynamically, you can skip the
        // <Resource>::setCredential($cred) calls that
        // you see in the samples.

        $cred = new OAuthTokenCredential(
            $configManager->get('acct1.ClientId'),
            $configManager->get('acct1.ClientSecret')
        );

        return $cred;
    }

    /**
     * grape payment details using the paymentId
     *
     * @param string            $paymentId
     * @param ApiContext | null $apiContext
     *
     * @return Payment
     */
    public static function getById($paymentId, ApiContext $apiContext = null)
    {
        return Payment::get($paymentId, $apiContext);
    }

    /**
     * grape all payment details
     *
     * @param array      $param
     * @param ApiContext $apiContext
     *
     * @return PaymentHistory
     */
    public static function getAll(array $param, ApiContext $apiContext = null)
    {
        return Payment::all($param, $apiContext);
    }

    /**
     * @return Address
     * @throws \InvalidArgumentException
     */
    public function address()
    {
        return new Address();
    }

    /**
     * @return Amount
     * @throws \InvalidArgumentException
     */
    public function amount()
    {
        return new Amount();
    }

    /**
     * @return Details
     * @throws \InvalidArgumentException
     */
    public function details()
    {
        return new Details();
    }

    /**
     * @return Authorization
     * @throws \InvalidArgumentException
     */
    public function authorization()
    {
        return new Authorization;
    }

    /**
     * @return Capture
     * @throws \InvalidArgumentException
     */
    public function capture()
    {
        return new Capture;
    }

    /**
     * @return CreditCard
     * @throws \InvalidArgumentException
     */
    public function creditCard()
    {
        return new CreditCard();
    }

    /**
     * @return CreditCardToken
     * @throws \InvalidArgumentException
     */
    public function creditCardToken()
    {
        return new CreditCardToken();
    }

    /**
     * @return FundingInstrument
     * @throws \InvalidArgumentException
     */
    public function fundingInstrument()
    {
        return new FundingInstrument();
    }

    /**
     * @return Item
     * @throws \InvalidArgumentException
     */
    public function item()
    {
        return new Item();
    }

    /**
     * @return ItemList
     * @throws \InvalidArgumentException
     */
    public function itemList()
    {
        return new ItemList();
    }

    /**
     * @return Links
     * @throws \InvalidArgumentException
     */
    public function links()
    {
        return new Links();
    }

    /**
     * @return Payee
     * @throws \InvalidArgumentException
     */
    public function payee()
    {
        return new Payee();
    }

    /**
     * @return Payer
     * @throws \InvalidArgumentException
     */
    public function payer()
    {
        return new Payer();
    }

    /**
     * @return PayerInfo
     * @throws \InvalidArgumentException
     */
    public function payerInfo()
    {
        return new PayerInfo();
    }

    /**
     * @return Payment
     * @throws \InvalidArgumentException
     */
    public function payment()
    {
        return new Payment();
    }

    /**
     * @return PaymentExecution
     * @throws \InvalidArgumentException
     */
    public function paymentExecution()
    {
        return new PaymentExecution();
    }

    /**
     * @return PaymentHistory
     * @throws \InvalidArgumentException
     */
    public function paymentHistory()
    {
        return new PaymentHistory();
    }

    /**
     * @return RedirectUrls
     * @throws \InvalidArgumentException
     */
    public function redirectUrls()
    {
        return new RedirectUrls();
    }

    /**
     * @return Refund
     * @throws \InvalidArgumentException
     */
    public function refund()
    {
        return new Refund();
    }

    /**
     * @return RelatedResources
     * @throws \InvalidArgumentException
     */
    public function relatedResources()
    {
        return new RelatedResources();
    }

    /**
     * @return Sale
     * @throws \InvalidArgumentException
     */
    public function sale()
    {
        return new Sale();
    }

    /**
     * @return ShippingAddress
     * @throws \InvalidArgumentException
     */
    public function shippingAddress()
    {
        return new ShippingAddress();
    }

    /**
     * @return Transactions
     * @throws \InvalidArgumentException
     */
    public function transactions()
    {
        return new Transactions();
    }

    /**
     * @return Transaction
     * @throws \InvalidArgumentException
     */
    public function transaction()
    {
        return new Transaction();
    }

    /**
     * @param null $clientId
     * @param null $clientSecret
     * @param null $requestId
     *
     * @return \PayPal\Rest\ApiContext
     */
    public function apiContext($clientId = null, $clientSecret = null, $requestId = null)
    {
        $credentials = self::OAuthTokenCredential($clientId, $clientSecret);

        return new ApiContext($credentials, $requestId);
    }

    /**
     * Get the base URL
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return URL::to('/');
    }

}
