
#### Note :
If you're going to use this package with Laravel 4, make sure to require the Laravel 4 branch: 
```js
"require": {
    "anouar/paypalpayment": "dev-l4"
}
```
laravel-paypalpayment
=====================
[![Build Status](https://travis-ci.org/xroot/laravel-paypalpayment.svg?branch=master)](https://travis-ci.org/xroot/laravel-paypalpayment)

laravel-paypalpayment is a simple package that helps you to process direct credit card payments, stored credit card payments and PayPal account payments with your Laravel 4/5 projects using PayPal REST API SDK.

## Donation :
donate a cup of :coffee: :blush: : <a href='https://pledgie.com/campaigns/24666'><img alt='Click here to lend your support to: github and make a donation at pledgie.com !' src='https://pledgie.com/campaigns/24666.png?skin_name=chrome' border='0' ></a>

## <a href='https://youtu.be/q5Xb5r4MUB8'>Watch a Quick Demo</a>
Installation
=============
Install this package through Composer. To your `composer.json` file:

```js
"require": {
    "anouar/paypalpayment": ">=2.1"
}
```

Next, run `composer update`.

Add the service provider to `config/app.php` (`app/config/app.php` for Laravel 4), in the `providers` array.

```php
'providers' => array(
    // ...

    Anouar\Paypalpayment\PaypalpaymentServiceProvider::class,
)
```

Then add an alias under `aliases` array.

```php
'aliases' => array(
    // ...

    'Paypalpayment'   => Anouar\Paypalpayment\Facades\PaypalPayment::class,
)
```
Finaly Pulish the package configuration by running this CMD 
    
    php artisan vendor:publish --provider="Anouar\Paypalpayment\PaypalpaymentServiceProvider"

## Configuration
Under `config/paypal_payment.php` configuration file set your paypal `client_id` and `client_secert` keys


Samples
============
#### Note: If you are not fan of using facade calls, you can resove the paypal payment service like so `app('paypalpayment')` then assign it to a property.

## 1-Using credit card as paypent method

Create new controller `PaypalPaymentController`:
```php
use Paypalpayment;
class PaypalPaymentController extends BaseController {

    /*
    * Process payment using credit card
    */
    public function paywithCreditCard()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $shippingAddress = Paypalpayment::shippingAddress();
        $shippingAddress->setLine1("3909 Witmer Road")
            ->setLine2("Niagara Falls")
            ->setCity("Niagara Falls")
            ->setState("NY")
            ->setPostalCode("14305")
            ->setCountryCode("US")
            ->setPhone("716-298-1822")
            ->setRecipientName("Jhone");

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
            ->setFundingInstruments([$fi]);

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
        $itemList->setItems([$item1,$item2])
            ->setShippingAddress($shippingAddress);


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
            ->setTransactions([$transaction]);

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create(Paypalpayment::apiContext());
        } catch (\PPConnectionException $ex) {
            return response()->json(["error" => $ex->getMessage()], 400);
        }

        return response()->json([$payment->toArray()], 200);
    }
     
}
```


## 2-Using Express Checkout as payment method

```php

    /*
    * Process payment with express checkout
    */
    public function paywithPaypal()
    {
        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $shippingAddress= Paypalpayment::shippingAddress();
        $shippingAddress->setLine1("3909 Witmer Road")
            ->setLine2("Niagara Falls")
            ->setCity("Niagara Falls")
            ->setState("NY")
            ->setPostalCode("14305")
            ->setCountryCode("US")
            ->setPhone("716-298-1822")
            ->setRecipientName("Jhone");

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("paypal");

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
        $itemList->setItems([$item1,$item2])
            ->setShippingAddress($shippingAddress);


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

        $redirectUrls = Paypalpayment::redirectUrls();
        $redirectUrls->setReturnUrl(url("/payments/success"))
            ->setCancelUrl(url("/payments/fails"));

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create(Paypalpayment::apiContext());
        } catch (\PPConnectionException $ex) {
            return response()->json(["error" => $ex->getMessage()], 400);
        }

        return response()->json([$payment->toArray(), 'approval_url' => $payment->getApprovalLink()], 200);
    }
```

## 3-List Payment
Add the `index()` function to the `PaypalPaymentController` Controller 
```php
    /*
        Use this call to get a list of payments. 
        url:payment/
    */
    public function index()
    {

        $payments = Paypalpayment::getAll(['count' => 1, 'start_index' => 0], Paypalpayment::apiContext());
        
        return response()->json([$payments->toArray()], 200);

    }
```

## 4-Get Payment details
Add the `show()` function to the `PaypalPaymentController` Controller 
```php
    /*
        Use this call to get details about payments that have not completed, 
        such as payments that are created and approved, or if a payment has failed.
        url:payment/PAY-3B7201824D767003LKHZSVOA
    */

    public function show($payment_id)
    {
       $payment = Paypalpayment::getById($payment_id, Paypalpayment::apiContext());
        
        return response()->json([$payment->toArray()], 200);
    }
```
Under the (`routes.php` for previous versions) or `web.php` file  and register your routing.

Conclusion
==========
Please feel free to report issues and open any PRs that you thinks will help to improve the package.
