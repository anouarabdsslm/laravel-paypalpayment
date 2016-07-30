## laravel-paypal

`laravel-paypal` handless direct credit card payments, stored credit card payments and PayPal account balance payments. It's developed for use with Laravel 5 and leverages the latest Paypal REST API SDK for PHP.

## Installation

1. Run this command in your Laravel project root to install using Composer
`composer require netshell/paypal dev-master`

2. Next, add the service provider to `app/config/app.php` in the `providers` array.

```php
'providers' => array(
    // ...
    'Netshell\Paypal\PaypalServiceProvider',
)
```

3. Finally, add an alias to `app/config/app.php` in the `aliases` array.

```php
'aliases' => array(
    // ...
    'Paypal' => 'Netshell\Paypal\Facades\Paypal',
)
```
##Configuration

Use the `$apiContext->setConfig()` method to pass in your PayPal details.
Below is one example of sandbox configuration in a controller constructor:
```php
    private $_apiContext;

    public function __construct()
    {
        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));
		
		$this->_apiContext->setConfig(array(
			'mode' => 'sandbox',
			'service.EndPoint' => 'https://api.sandbox.paypal.com',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => storage_path('logs/paypal.log'),
			'log.LogLevel' => 'FINE'
		));

    }

```

Given you have set your developer information in `config/services.php`:
```
'paypal' => [
	'client_id' => 'Client_ID',
	'secret' => 'Your_secret'
],

```

## Code Samples

### List Payments
```php
Paypal::getAll(array('count' => 1, 'start_index' => 0), $this->_apiContext);
```

### Payment Details
```php
Paypal::getById($payment_id, $this->_apiContext);
```

### Example Controller

This example provides you have a controller that runs the package configuration like in the snippet in the Configuration section.

```php
use PayPal;
use Redirect;
// ...
public function getCheckout()
{
	$payer = PayPal::Payer();
	$payer->setPaymentMethod('paypal');

	$amount = PayPal:: Amount();
	$amount->setCurrency('EUR');
	$amount->setTotal(42); // This is the simple way,
	// you can alternatively describe everything in the order separately;
	// Reference the PayPal PHP REST SDK for details.

	$transaction = PayPal::Transaction();
	$transaction->setAmount($amount);
	$transaction->setDescription('What are you selling?');

	$redirectUrls = PayPal:: RedirectUrls();
	$redirectUrls->setReturnUrl(action('ThisController@getDone'));
	$redirectUrls->setCancelUrl(action('ThisController@getCancel'));

	$payment = PayPal::Payment();
	$payment->setIntent('sale');
	$payment->setPayer($payer);
	$payment->setRedirectUrls($redirectUrls);
	$payment->setTransactions(array($transaction));

	$response = $payment->create($this->_apiContext);
	$redirectUrl = $response->links[1]->href;
	
	return Redirect::to( $redirectUrl );
}

public function getDone(Request $request)
{
	$id = $request->get('paymentId');
	$token = $request->get('token');
	$payer_id = $request->get('PayerID');
	
	$payment = PayPal::getById($id, $this->_apiContext);

	$paymentExecution = PayPal::PaymentExecution();

	$paymentExecution->setPayerId($payer_id);
	$executePayment = $payment->execute($paymentExecution, $this->_apiContext);

    // Clear the shopping cart, write to database, send notifications, etc.

    // Thank the user for the purchase
	return view('checkout.done');
}

public function getCancel()
{
    // Curse and humiliate the user for cancelling this most sacred payment (yours)
	return view('checkout.cancel');
}
```
### Customize Paypal payment page

First we need to create a new WebProfile for obtain the id, then in the future we can simply set this id to the payment object.

```php
public function createWebProfile(){

	$flowConfig = PayPal::FlowConfig();
	$presentation = PayPal::Presentation();
	$inputFields = PayPal::InputFields();
	$webProfile = PayPal::WebProfile();
	$flowConfig->setLandingPageType("Billing"); //Set the page type

	$presentation->setLogoImage("https://www.example.com/images/logo.jpg")->setBrandName("Example ltd"); //NB: Paypal recommended to use https for the logo's address and the size set to 190x60.

	$inputFields->setAllowNote(true)->setNoShipping(1)->setAddressOverride(0);
	
	$webProfile->setName("Example " . uniqid())
		->setFlowConfig($flowConfig)
		// Parameters for style and presentation.
		->setPresentation($presentation)
		// Parameters for input field customization.
		->setInputFields($inputFields);

	$createProfileResponse = $webProfile->create($this->_apiContext);
        
	return $createProfileResponse->getId(); //The new webprofile's id
}
```

Now set the WebProfile's id to the payment object `$payment->setExperienceProfileId("XP-ABCD-EFGH-ILMN-OPQR");`
