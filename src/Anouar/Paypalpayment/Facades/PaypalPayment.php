<?php namespace Anouar\Paypalpayment\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class PaypalPayment extends Facade {
 
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'paypalpayment'; }
 
}