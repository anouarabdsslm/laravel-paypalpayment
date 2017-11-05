<?php
namespace Anouar\Paypalpayment;

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
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalPayment
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return \PayPal\Api\Address
     */
    public function address()
    {
        return new Address;
    }

    /**
     * @return \PayPal\Api\Amount
     */
    public function amount()
    {
        return new Amount;
    }

    /**
     * @return \PayPal\Api\Details
     */
    public function details()
    {
        return new Details;
    }

    /**
     * @return \PayPal\Api\Authorization
     */
    public function authorization()
    {
        return new Authorization;
    }

    /**
     * @return \PayPal\Api\Capture
     */
    public function capture()
    {
        return new Capture;
    }

    /**
     * @return \PayPal\Api\CreditCard
     */
    public function creditCard()
    {
        return new CreditCard;
    }

    /**
     * @return \PayPal\Api\CreditCardToken
     */
    public function creditCardToken()
    {
        return new CreditCardToken;
    }

    /**
     * @return \PayPal\Api\FundingInstrument
     */
    public function fundingInstrument()
    {
        return new FundingInstrument;
    }

    /**
     * @return \PayPal\Api\Item
     */
    public function item()
    {
        return new Item;
    }

    /**
     * @return \PayPal\Api\ItemList
     */
    public function itemList()
    {
        return new ItemList;
    }

    /**
     * @return \PayPal\Api\Links
     */
    public function links()
    {
        return new Links;
    }

    /**
     * @return \PayPal\Api\Payee
     */
    public function payee()
    {
        return new Payee;
    }

    /**
     * @return \PayPal\Api\Payer
     */
    public function payer()
    {
        return new Payer;
    }

    /**
     * @return \PayPal\Api\PayerInfo
     */
    public function payerInfo()
    {
        return new PayerInfo;
    }

    /**
     * @return \PayPal\Api\Payment
     */
    public function payment()
    {
        return new Payment;
    }

    /**
     * @return \PayPal\Api\PaymentExecution
     */
    public function paymentExecution()
    {
        return new PaymentExecution;
    }

    /**
     * @return \PayPal\Api\PaymentHistory
     */
    public function paymentHistory()
    {
        return new PaymentHistory;
    }

    /**
     * @return \PayPal\Api\RedirectUrls
     */
    public function redirectUrls()
    {
        return new RedirectUrls;
    }

    /**
     * @return \PayPal\Api\Refund
     */
    public function refund()
    {
        return new Refund;
    }

    /**
     * @return \PayPal\Api\RelatedResources
     */
    public function relatedResources()
    {
        return new RelatedResources;
    }

    /**
     * @return \PayPal\Api\Sale
     */
    public function sale()
    {
        return new Sale;
    }

    /**
     * @return \PayPal\Api\ShippingAddress
     */
    public function shippingAddress()
    {
        return new ShippingAddress;
    }

    /**
     * @return \PayPal\Api\Transactions
     */
    public function transactions()
    {
        return new Transactions;
    }

    /**
     * @return \PayPal\Api\Transaction
     */
    public function transaction()
    {
        return new Transaction;
    }


    /**
     * @param null $clientId
     * @param null $clientSecret
     * @param null $requestId
     * @return \PayPal\Rest\ApiContext
     */
    public function apiContext($clientId = null, $clientSecret = null, $requestId = null)
    {
        if (!is_null($clientId)) {
            $this->config['account']['client_id'] = $clientId;
        }

        if (!is_null($clientSecret)) {
            $this->config['account']['client_secret'] = $clientSecret;
        }

        $apiContext = new ApiContext($this->oAuthTokenCredential(), $requestId);

        $apiContext->setConfig([
            'mode' => $this->config['mode'],
            'http.ConnectionTimeOut' => $this->config['http']['connection_time_out'],
            'log.LogEnabled' => $this->config['log']['log_enabled'],
            'log.FileName' => $this->config['log']['file_name'],
            'log.LogLevel' => $this->config['log']['log_level']
        ]);

        return $apiContext;
    }

    /**
     * @param null $clientId
     * @param null $clientSecret
     * @return PayPal/Auth/OAuthTokenCredential
     */
    public function oAuthTokenCredential()
    {
        return new OAuthTokenCredential($this->config['account']['client_id'], $this->config['account']['client_secret']);
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
     * @return \PayPal\Api\Payment
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
     * @return \PayPal\Api\Payment
     */
    public static function getAll($param, $apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::all($param, $apiContext);
        }
        return Payment::all($param);
    }
}
