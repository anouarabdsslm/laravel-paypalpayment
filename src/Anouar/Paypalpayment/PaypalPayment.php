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
     * @var Paypal\Api\Address
     */
    private $address;
    /**
     * @var Paypal\Api\Amount
     */
    private $amount;
    /**
     * @var Paypal\Api\Details
     */
    private $details;
    /**
     * @var Paypal\Api\Authorization
     */
    private $authorization;
    /**
     * @var Paypal\Api\Capture
     */
    private $capture;
    /**
     * @var Paypal\Api\CreditCard
     */
    private $creditCard;
    /**
     * @var Paypal\Api\CreditCardToken
     */
    private $creditCardToken;
    /**
     * @var Paypal\Api\FundingInstrument
     */
    private $fundingInstrument;
    /**
     * @var Paypal\Api\Item
     */
    private $item;
    /**
     * @var Paypal\Api\ItemList
     */
    private $itemList;
    /**
     * @var Paypal\Api\Links
     */
    private $links;
    /**
     * @var Paypal\Api\Payee
     */
    private $payee;
    /**
     * @var Paypal\Api\Payer
     */
    private $payer;
    /**
     * @var Paypal\Api\PayerInfo
     */
    private $payerInfo;
    /**
     * @var Paypal\Api\Payment
     */
    private $payment;
    /**
     * @var Paypal\Api\PaymentExecution
     */
    private $paymentExecution;
    /**
     * @var Paypal\Api\PaymentHistory
     */
    private $paymentHistory;
    /**
     * @var Paypal\Api\RedirectUrls
     */
    private $redirectUrls;
    /**
     * @var Paypal\Api\Refund
     */
    private $refund;
    /**
     * @var Paypal\Api\RelatedResources
     */
    private $relatedResources;
    /**
     * @var Paypal\Api\Sale
     */
    private $sale;
    /**
     * @var Paypal\Api\ShippingAddress
     */
    private $shippingAddress;
    /**
     * @var Paypal\Api\Transactions
     */
    private $transactions;
    /**
     * @var Paypal\Api\Transaction
     */
    private $transaction;

    /**
     * @param Address $address
     * @param Amount $amount
     * @param Details $details
     * @param Authorization $authorization
     * @param Capture $capture
     * @param CreditCard $creditCard
     * @param CreditCardToken $creditCardToken
     * @param FundingInstrument $fundingInstrument
     * @param Item $item
     * @param ItemList $itemList
     * @param Links $links
     * @param Payee $payee
     * @param Payer $payer
     * @param PayerInfo $payerInfo
     * @param Payment $payment
     * @param PaymentExecution $paymentExecution
     * @param PaymentHistory $paymentHistory
     * @param RedirectUrls $redirectUrls
     * @param Refund $refund
     * @param RelatedResources $relatedResources
     * @param Sale $sale
     * @param ShippingAddress $shippingAddress
     * @param Transactions $transactions
     * @param Transaction $transaction
     */
    public function __construct(Address $address, Amount $amount, Details $details, Authorization $authorization,
                    Capture $capture, CreditCard $creditCard, CreditCardToken $creditCardToken,
                    FundingInstrument $fundingInstrument,Item $item, ItemList $itemList, Links $links,
                    Payee $payee, Payer $payer, PayerInfo $payerInfo,Payment $payment, PaymentExecution $paymentExecution,
                    PaymentHistory $paymentHistory, RedirectUrls $redirectUrls, Refund $refund,RelatedResources $relatedResources,
                    Sale $sale, ShippingAddress $shippingAddress, Transactions $transactions,Transaction $transaction
            )
    {
        $this->address = $address;
        $this->amount = $amount;
        $this->details = $details;
        $this->authorization = $authorization;
        $this->capture = $capture;
        $this->creditCard = $creditCard;
        $this->creditCardToken = $creditCardToken;
        $this->fundingInstrument = $fundingInstrument;
        $this->item = $item;
        $this->itemList = $itemList;
        $this->links = $links;
        $this->payee = $payee;
        $this->payer = $payer;
        $this->payerInfo = $payerInfo;
        $this->payment = $payment;
        $this->paymentExecution = $paymentExecution;
        $this->paymentHistory = $paymentHistory;
        $this->redirectUrls = $redirectUrls;
        $this->refund = $refund;
        $this->relatedResources = $relatedResources;
        $this->sale = $sale;
        $this->shippingAddress = $shippingAddress;
        $this->transactions = $transactions;
        $this->transaction = $transaction;
    }

    /**
     * @return Paypal\Api\Address
     */
    public function address()
    {
        return $this->address;
    }

    /**
     * @return Paypal\Api\Amount
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return Paypal\Api\Details
     */
    public  function details()
    {
        return $this->details;
    }

    /**
     * @return Paypal\Api\Authorization
     */
    public  function authorization()
    {
        return $this->authorization;
    }

    /**
     * @return Paypal\Api\Capture
     */
    public  function capture()
    {
        return $this->capture;
    }

    /**
     * @return Paypal\Api\CreditCard
     */
    public  function creditCard()
    {
        return $this->creditCard;
    }

    /**
     * @return Paypal\Api\CreditCardToken
     */
    public  function creditCardToken()
    {
        return $this->creditCardToken;
    }

    /**
     * @return Paypal\Api\FundingInstrument
     */
    public  function fundingInstrument()
    {
        return $this->fundingInstrument;
    }

    /**
     * @return Paypal\Api\Item
     */
    public  function item()
    {
        return $this->item;
    }

    /**
     * @return Paypal\Api\ItemList
     */
    public  function itemList()
    {
        return $this->itemList;
    }

    /**
     * @return Paypal\Api\Links
     */
    public  function links()
    {
        return $this->links;
    }

    /**
     * @return Paypal\Api\Payee
     */
    public  function payee()
    {
        return $this->payee;
    }

    /**
     * @return Paypal\Api\Payer
     */
    public  function payer()
    {
        return $this->payer;
    }

    /**
     * @return Paypal\Api\PayerInfo
     */
    public  function payerInfo()
    {
        return $this->payerInfo;
    }

    /**
     * @return Paypal\Api\Payment
     */
    public  function payment()
    {
        return $this->payment;
    }

    /**
     * @return Paypal\Api\PaymentExecution
     */
    public  function paymentExecution()
    {
        return $this->paymentExecution;
    }

    /**
     * @return Paypal\Api\PaymentHistory
     */
    public  function paymentHistory()
    {
        return $this->paymentHistory;
    }

    /**
     * @return Paypal\Api\RedirectUrls
     */
    public  function redirectUrls()
    {
        return $this->redirectUrls;
    }

    /**
     * @return Paypal\Api\Refund
     */
    public  function refund()
    {
        return $this->refund;
    }

    /**
     * @return Paypal\Api\RelatedResources
     */
    public  function relatedResources()
    {
        return $this->relatedResources;
    }

    /**
     * @return Paypal\Api\Sale
     */
    public  function sale()
    {
        return $this->sale;
    }

    /**
     * @return Paypal\Api\ShippingAddress
     */
    public  function shippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @return Paypal\Api\Transactions
     */
    public  function transactions()
    {
        return $this->transactions;
    }

    /**
     * @return Paypal\Api\Transaction
     */
    public function transaction()
    {
        return $this->transaction;
    }


    /**
     * @param null $clientId
     * @param null $clientSecret
     * @param null $requestId
     * @return Paypal\Rest\ApiContext
     */
    public function apiContext($clientId = null, $clientSecret = null, $requestId = null)
    {
        $credentials = Self::OAuthTokenCredential($clientId, $clientSecret);

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
    public static function get($paymentId, $apiContext = null)
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
    public static function all($param,$apiContext = null)
    {
        if (isset($apiContext)) {
            return Payment::all($param, $apiContext);
        }
        return Payment::all($param);
    }

}
