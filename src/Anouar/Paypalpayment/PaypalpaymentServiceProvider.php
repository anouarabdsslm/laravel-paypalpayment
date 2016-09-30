<?php

namespace Anouar\Paypalpayment;

use Illuminate\Support\ServiceProvider;

/**
 * Class PaypalpaymentServiceProvider
 *
 * @package Anouar\Paypalpayment
 */
class PaypalpaymentServiceProvider extends ServiceProvider
{

    const PAYPALPAYMENT = 'paypalpayment';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app[self::PAYPALPAYMENT] = $this->app->share(
            function () {
                return new PaypalPayment();
            }
        );

        $this->publishes(
            [
                __DIR__ . '/../../config/paypal_payment.php' => config_path('paypal_payment.php'),
            ]
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [self::PAYPALPAYMENT];
    }
}
