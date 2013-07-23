<?php namespace Anouar\Paypalpayment;

use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaypalPayment{
	
	//Utilities fucntions
	public static function OAuthTokenCredential($ClientId=null,$ClientSecret=null) {

		define("PP_CONFIG_PATH", __DIR__);

		if(isset($ClientId) && isset($ClientSecret)){

			return new OAuthTokenCredential($ClientId,$ClientSecret);

		}

		$configManager 	= \PPConfigManager::getInstance();
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
 

	/**
	 * ### getBaseUrl function
	 * // utility function that returns base url for
	 * // determining return/cancel urls
	 * @return string
	 */
	public static function getBaseUrl() {

		$protocol = 'http';
		if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
			$protocol .= 's';
			$protocol_port = $_SERVER['SERVER_PORT'];
		} else {
			$protocol_port = 80;
		}

		$host = $_SERVER['HTTP_HOST'];
		$port = $_SERVER['SERVER_PORT'];
		$request = $_SERVER['PHP_SELF'];
		return dirname($protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request);
	}

	//Class functions

	public static function Address(){
   	 	return new Address();
  	}

  	public static function CreditCard(){

  		return new CreditCard();
  	}

  	public static function FundingInstrument(){

  		return new FundingInstrument();
  	}

  	public static function Payer(){
  		return new Payer();
  	}

  	public static function Amount(){
  		return new Amount();
  	}

  	public static function Transaction(){
  		return new Transaction();
  	}

  	public static function Payment(){
  		return new Payment();
  	}

  	public static function getPayment($paymentId){
  		return Payment::get($paymentId);
  	}


  	public static function ApiContext($credential, $requestId=null){
  		return new ApiContext($credential, $requestId);
  	}

  	public static function RedirectUrls(){
  		return new RedirectUrls();
  	}

  	public static function PaymentExecution(){
  		return new PaymentExecution();
  	}

}
