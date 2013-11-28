<?php namespace Anouar\Paypalpayment;

use Illuminate\Support\ServiceProvider;

class PaypalpaymentServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('anouar/paypalpayment');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['paypalpayment'] = $this->app->share(function($app)
        {
            return new PaypalPayment;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('paypalpayment');
    }

}
