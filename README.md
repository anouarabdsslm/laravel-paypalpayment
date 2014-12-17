
laravel-paypalpayment
=====================
[![Build Status](https://travis-ci.org/xroot/laravel-paypalpayment.svg?branch=master)](https://travis-ci.org/xroot/laravel-paypalpayment)

laravel-paypalpayment is simple package  help you process   direct credit card payments, stored credit card payments and PayPal account payments with your L4 projects using paypal REST API SDK.

##Donation :
If you want to support us: <a href='https://pledgie.com/campaigns/24666'><img alt='Click here to lend your support to: github and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/24666.png?skin_name=chrome' border='0' ></a>
Installation
=============
Install this package through Composer. To your `composer.json` file, add:

```js
"require": {
    "anouar/paypalpayment": "1.*"
}
```

Next, run `composer update` to download it.

Add the service provider to `app/config/app.php`, within the `providers` array.

```php
'providers' => array(
    // ...

    'Anouar\Paypalpayment\PaypalpaymentServiceProvider',
)
```

Finally, add the alias to `app/config/app.php`, within the `aliases` array.

```php
'aliases' => array(
    // ...

    'Paypalpayment'   => 'Anouar\Paypalpayment\Facades\PaypalPayment',
)
```
##Configuration
Now go to `vendor\anouar\paypalpayment\src\Anouar\Paypalpayment\sdk_config.ini`

Set your SDK configuration `acct1.ClientId` and `acct1.ClientSecret` , set the `service.EndPoint` to the mode that you want , by default it set to testing mode which is`service.EndPoint="https://api.sandbox.paypal.com"`.If you were going  live , make sure to comment the sandbox mode and uncomment the live mode
.

```
;Account credentials from developer portal
[Account]
acct1.ClientId =AVJx0RArQzkCCsWC0evZi1SsoO4gxjDkkULQBdmPNBZ4fc14AROUq-etMEY
acct1.ClientSecret =EH5F0BAxqonVnP8M4a0c6ezUHq-UT-CWfGciPNQdUlTpWPkNyuS6eDN-tpA


;Connection Information
[Http]
http.ConnectionTimeOut = 30
http.Retry = 1
;http.Proxy=http://[username:password]@hostname[:port][/path]


;Service Configuration
[Service]
service.EndPoint="https://api.sandbox.paypal.com"
; Uncomment this line for integrating with the live endpoint 
; service.EndPoint="https://api.paypal.com"


;Logging Information
[Log]

log.LogEnabled=true

# When using a relative path, the log file is created
# relative to the .php file that is the entry point
# for this request. You can also provide an absolute
# path here
log.FileName=../PayPal.log

# Logging level can be one of FINE, INFO, WARN or ERROR
# Logging is most verbose in the 'FINE' level and
# decreases as you proceed towards ERROR
log.LogLevel=FINE
```

If you do not want to use an ini file or want to pick your configuration dynamically, you can use the `$apiContext->setConfig()` method to pass in the configuration.
```php
    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /**
     * Set the ClientId and the ClientSecret.
     * @param 
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId='AVJx0RArQzkCCsWC0evZi1SsoO4gxjDkkULQBdmPNBZT4fc14AROUq-etMEY';
    private $_ClientSecret='EH5F0BAxqonVnP8M4a0c6ezUHq-UT-CWfGciPNQOdUlTpWPkNyuS6eDN-tpA';

    /*
     *   These construct set the SDK configuration dynamiclly, 
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct()
    {

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate 
        // the call. You can also send a unique request id 
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly. 

        $this->_apiContext = Paypalpayment::ApiContext($this->_ClientId, $this->_ClientSecret);

        // Uncomment this step if you want to use per request 
        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));

    }

```
That's it !!!!!
==============

Example Code
============

##1-Initiate The Configuration
Create new controller `PaypalPaymentController` and initiate the configuration :
```php

class PaypalPaymentController extends BaseController {

    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId = 'AVJx0RArQzkCCsWC0evZi1SsoO4gxjDkkULQBdmPNBZT4fc14AROUq-etMEU';
    private $_ClientSecret='EH5F0BAxqonVnP8M4a0c6ezUHq-UT-CWfGciPNQOdUlTpWPkNyuS6eDN-tpB';

    /*
     *   These construct set the SDK configuration dynamiclly,
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct()
    {

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate
        // the call. You can also send a unique request id
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly.

        $this->_apiContext = Paypalpayment::ApiContext($this->_ClientId, $this->_ClientSecret);

        // Uncomment this step if you want to use per request
        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));
    }
     
}
```

##2-Create Payment 
Add the `create()` function to the `PaypalPaymentController` Controller 

```php

    /*
    * Display form to process payment using credit card
    */
    public function create()
    {
        return View::mak('payment.order')
    }

    /*
    * Process payment using credit card
    */
    public function store()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr= Paypalpayment::address();
        $addr->setLine1("3909 Witmer Road");
        $addr->setLine2("Niagara Falls");
        $addr->setCity("Niagara Falls");
        $addr->setState("NY");
        $addr->setPostal_code("14305");
        $addr->setCountry_code("US");
        $addr->setPhone("716-298-1822");

        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
            ->setNumber("4758411877817150")
            ->setExpireMonth("05")
            ->setExpireYear("2019")
            ->setCvv2("456")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCredit_card($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $item1 = Paypalpayment::item();
        $item1->setName('Ground Coffee 40 oz')
                ->setDescription('Ground Coffee 40 oz')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setTax(0.3)
                ->setPrice(7.50);

        $item2 = Paypalpayment::item();
        $item2->setName('Granola bars')
                ->setDescription('Granola Bars with Peanuts')
                ->setCurrency('USD')
                ->setQuantity(5)
                ->setTax(0.2)
                ->setPrice(2);


        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item1,$item2));


        $details = Paypalpayment::details();
        $details->setShipping("1.2")
                ->setTax("1.3")
                //total of items prices
                ->setSubtotal("17.5");

        //Payment Amount
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
                // the total is $17.8 = (16 + 0.6) * 1 ( of quantity) + 1.2 ( of Shipping).
                ->setTotal("20")
                ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        dd($payment);
    } 
```
##3-List Payment
Add the `index()` function to the `PaypalPaymentController` Controller 
```php
    /*
        Use this call to get a list of payments. 
        url:payment/
    */
    public function index()
    {
        echo "<pre>";

        $payments = Paypalpayment::getAll(array('count' => 1, 'start_index' => 0), $this->_apiContext);

        dd($payments);
    }
```

##4-Get Payment details
Add the `show()` function to the `PaypalPaymentController` Controller 
```php
    /*
        Use this call to get details about payments that have not completed, 
        such as payments that are created and approved, or if a payment has failed.
        url:payment/PAY-3B7201824D767003LKHZSVOA
    */

    public function show($payment_id)
    {
       $payment = Paypalpayment::getById($payment_id,$this->_apiContext);

       dd($payment);
    }
```

##5-Execute Payment
Only for Payment with `payment_method` as `"paypal"`
```php
    // Get the payment Object by passing paymentId
    // payment id and payer ID was previously stored in database in
    // create() fuction , this function create payment using "paypal" method
    $paymentId = '';grape it from DB;
    $PayerID = '';grape it from DB;
    $payment = Paypalpayment::get($paymentId, $this->_apiContext);
    
    // PaymentExecution object includes information necessary 
    // to execute a PayPal account payment. 
    // The payer_id is added to the request query parameters
    // when the user is redirected from paypal back to your site
    $execution = Paypalpayment::PaymentExecution();
    $execution->setPayerId($PayerID);
    
    //Execute the payment
    $payment->execute($execution,$this->_apiContext);
```
Go to your `routes.php` file  and register a resourceful route to the controller:` Route::resource('payment', 'PaypalPaymentController');`

These examples pick the SDK configuration dynamiccly.If you want to pick your configuration from the sdk_config.ini file make sure to set thus configuration there. 
Conclusion
==========
I hope this package help someone around -_*
