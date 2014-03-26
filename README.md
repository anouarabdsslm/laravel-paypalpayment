
laravel-paypalpayment
=====================

laravel-paypalpayment is simple package  help you process   direct credit card payments, stored credit card payments and PayPal account payments with your L4 projects using paypal REST API SDK.

##Donation :
If you want to support us: <a href='https://pledgie.com/campaigns/24666'><img alt='Click here to lend your support to: github and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/24666.png?skin_name=chrome' border='0' ></a>
Installation
=============
Install this package through Composer. To your `composer.json` file, add:

```js
"require-dev": {
    "anouar/paypalpayment": "dev-master"
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

        $this->_apiContext = Paypalpayment::ApiContext(
            Paypalpayment::OAuthTokenCredential(
                $this->_ClientId,
                $this->_ClientSecret
            )
        );

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

        $this->_apiContext = Paypalpayment:: ApiContext(
            Paypalpayment::OAuthTokenCredential(
                $this->_ClientId,
                $this->_ClientSecret
            )
        );

        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
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
     * Create payment using credit card
     * url:payment/create
    */
    public function create()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr= Paypalpayment::Address();
        $addr->setLine1("3909 Witmer Road");
        $addr->setLine2("Niagara Falls");
        $addr->setCity("Niagara Falls");
        $addr->setState("NY");
        $addr->setPostal_code("14305");
        $addr->setCountry_code("US");
        $addr->setPhone("716-298-1822");

        // ### CreditCard
        // A resource representing a credit card that can be
        // used to fund a payment.
        $card = Paypalpayment::CreditCard();
        $card->setType("visa");
        $card->setNumber("4417119669820331");
        $card->setExpire_month("11");
        $card->setExpire_year("2019");
        $card->setCvv2("012");
        $card->setFirst_name("Anouar");
        $card->setLast_name("Abdessalam");
        $card->setBilling_address($addr);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::FundingInstrument();
        $fi->setCredit_card($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::Payer();
        $payer->setPayment_method("credit_card");
        $payer->setFunding_instruments(array($fi));

        // ### Amount
        // Let's you specify a payment amount.
        $amount = Paypalpayment:: Amount();
        $amount->setCurrency("USD");
        $amount->setTotal("1.00");

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = Paypalpayment:: Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("This is the payment description.");

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'
        $payment = Paypalpayment:: Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));

        // ### Create Payment
        // Create a payment by posting to the APIService
        // using a valid ApiContext
        // The return object contains the status;
        try {
            $payment->create($this->_apiContext);
        } catch (\PPConnectionException $ex) {
            return "Exception: " . $ex->getMessage() . PHP_EOL;
            var_dump($ex->getData());
            exit(1);
        }

        $response=$payment->toArray();

        echo"<pre>";
        print_r($response);
       
        //var_dump($payment->getId());

        //print_r($payment->toArray());//$payment->toJson();
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

        $payments = Paypalpayment::all(array('count' => 1, 'start_index' => 0),$this->_apiContext);

        print_r($payments);
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
       $payment = Paypalpayment::get($payment_id,$this->_apiContext);

       echo "<pre>";

       print_r($payment);
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
    $execution->setPayer_id($PayerID);
    
    //Execute the payment
    $payment->execute($execution,$this->_apiContext);
```
Go to your `routes.php` file  and register a resourceful route to the controller:` Route::resource('payment', 'PaypalPaymentController');`

These examples pick the SDK configuration dynamiccly.If you want to pick your configuration from the sdk_config.ini file make sure to set thus configuration there. 
Conclusion
==========
I hope this package help someone around -_*
