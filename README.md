laravel-paypalpayment
=====================

laravel-paypalpayment is simple package that help you process credit card payment with your L4 projects using paypal API, this package support also the other paypal methodes. 
Installation
=============
Install this package through Composer. To your `composer.json` file, add:

```js
"require-dev": {
	"anouar/paypalpayment": "dev-master"
}
```

Next, run `composer install --dev` or `composer update` to download it.

Finally, add the service provider to `app/config/app.php`, within the `providers` array.

```php
'providers' => array(
	// ...

	'Anouar\Paypalpayment\PaypalpaymentServiceProvider',
)
```

add the the alias to `app/config/app.php`, within the `aliases` array.

```php
'aliases' => array(
	// ...

	'Paypalpayment'	  => 'Anouar\Paypalpayment\Facades\PaypalPayment',
)
```
