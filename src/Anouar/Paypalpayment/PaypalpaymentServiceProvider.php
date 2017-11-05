<?php namespace Anouar\Paypalpayment;

use Illuminate\Support\ServiceProvider;

class PaypalpaymentServiceProvider extends ServiceProvider
{

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
        $this->app->singleton('paypalpayment', function ($app) {
            $config = [
                'mode' => config('paypal_payment.mode'),

                'account' => [
                    'client_id' => config('paypal_payment.account.client_id'),
                    'client_secret' => config('paypal_payment.account.client_secret'),
                ],

                'http' => [
                    'connection_time_out' => config('paypal_payment.http.connection_time_out'),
                ],

                'log' => [
                    'log_enabled' => config('paypal_payment.log.log_enabled'),
                    'file_name' => config('paypal_payment.log.file_name'),
                    'log_level' => config('paypal_payment.log.log_level'),
                ],
            ];

            return new PaypalPayment($config);
        });

        $this->publishes([
            __DIR__.'/../../config/paypal_payment.php' => config_path('paypal_payment.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['paypalpayment'];
    }
}
