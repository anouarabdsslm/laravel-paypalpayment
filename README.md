
##Note :
If you're going to use this package with Laravel 4, make sure to include the Laravel 4 version: 
```js
"require": {
    "anouar/paypalpayment": "dev-l4"
}
```
laravel-paypalpayment
=====================
[![Build Status](https://travis-ci.org/xroot/laravel-paypalpayment.svg?branch=master)](https://travis-ci.org/xroot/laravel-paypalpayment)

laravel-paypalpayment is a simple package that helps you to process direct credit card payments, stored credit card payments and PayPal account payments with your Laravel 4/5 projects using PayPal REST API SDK.

##Donation :
If you want to support us: <a href='https://pledgie.com/campaigns/24666'><img alt='Click here to lend your support to: github and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/24666.png?skin_name=chrome' border='0' ></a>

## <a href='https://youtu.be/q5Xb5r4MUB8'>Watch a Quick Demo</a>
Installation
=============
Install this package through Composer. To your `composer.json` file, add:

```js
"require": {
    "anouar/paypalpayment": "~1.0"
}
```

Next, run `composer update` to download it.

Add the service provider to `config/app.php` (`app/config/app.php` in Laravel 4), within the `providers` array.

```php
'providers' => array(
    // ...

    'Anouar\Paypalpayment\PaypalpaymentServiceProvider',
)
```

Then add an alias to `config/app.php` (`app/config/app.php`), within the `aliases` array.

```php
'aliases' => array(
    // ...

    'Paypalpayment'   => 'Anouar\Paypalpayment\Facades\PaypalPayment',
)
```
Finaly Pulish the package configuration by running this CMD 
    
    php artisan vendor:publish --provider="Anouar\Paypalpayment\PaypalpaymentServiceProvider"

##Configuration
Use the `$apiContext->setConfig()` method to pass in the configuration.
```php
    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
    private $_apiContext;

    public function __construct()
    {

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate 
        // the call. You can also send a unique request id 
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly. 

        $this->_apiContext = Paypalpayment::apiContext($this->_ClientId, $this->_ClientSecret);

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

    public function __construct()
    {

        // ### Api Context
        // Pass in a `ApiContext` object to authenticate
        // the call. You can also send a unique request id
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly.

        $this->_apiContext = Paypalpayment::ApiContext(config('paypal_payment.Account.ClientId'), config('paypal_payment.Account.ClientSecret'));

    }
     
}
```

If you want to use the Laravel config file: The first step is to publish the config with 
   
    php artisan vendor:publish --provider="Anouar\Paypalpayment\PaypalpaymentServiceProvider"

This will create the config file `storage/paypal_payment.php` (`app/config/paypal_payment.php` in Laravel 4). Configurate it, then replace the `setConfig()` method call (see above) with:

```
$config = config('paypal_payment'); // Get all config items as multi dimensional array
$flatConfig = array_dot($config); // Flatten the array with dots

$this->_apiContext->setConfig($flatConfig);
```

##2-Create Payment 
#Credit card payment
Add the `create()` function to the `PaypalPaymentController` Controller 

```php

    /*
    * Display form to process payment using credit card
    */
    public function create()
    {
        return View::make('payment.order');
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
        $addr->setPostalCode("14305");
        $addr->setCountryCode("US");
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
        $fi->setCreditCard($card);

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
#paypal payment
```
    public function store()
    {
        // ### Payer
        // A resource representing a Payer that funds a payment
        // For paypal account payments, set payment method
        // to 'paypal'.
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

        // ### Itemized information
        // (Optional) Lets you specify item wise
        // information
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
        $itemList->setItems(array($item1, $item2));

        $details = Paypalpayment::details();
        $details->setShipping('1.2')
                ->setTax('1.3')
                //total of items prices
                ->setSubtotal('17.5');

        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.
        $details = Paypalpayment::details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.50);

        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = Paypalpayment::amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. 
        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after 
        // payment approval/ cancellation.
        $baseUrl = "http://localhost:8000";
        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls->setReturnUrl("{$baseUrl}/callback?success=true")
            ->setCancelUrl("{$baseUrl}/callback?success=false");

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to 'sale'
        $payment = Paypalpayment::payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        // ### Create Payment
        // Create a payment by calling the 'create' method
        // passing it a valid apiContext.
        // (See bootstrap.php for more on `ApiContext`)
        // The return object contains the state and the
        // url to which the buyer must be redirected to
        // for payment approval
        try {
            $payment->create($this->apiContext);
        } catch (\Exception $ex) {
            \Log::error($ex);
        }

        // ### Get redirect url
        // The API response provides the url that you must redirect
        // the buyer to. Retrieve the url from the $payment->getApprovalLink()
        // method
        $approvalUrl = $payment->getApprovalLink();
        echo "Created Payment Using PayPal. Please visit the URL to Approve.Payment <a href={$approvalUrl}>{$approvalUrl}</a>";
        var_dump($payment);
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
    $payment = Paypalpayment::getById($paymentId, $this->_apiContext);
    
    // PaymentExecution object includes information necessary 
    // to execute a PayPal account payment. 
    // The payer_id is added to the request query parameters
    // when the user is redirected from paypal back to your site
    $execution = Paypalpayment::PaymentExecution();
    $execution->setPayerId($PayerID);
    
    //Execute the payment
    $payment->execute($execution,$this->_apiContext);
```
Go to your `routes.php` file  and register a resourceful route to the controller: `Route::resource('payment', 'PaypalPaymentController');`

Conclusion
==========
I hope this package help someone around -_*
