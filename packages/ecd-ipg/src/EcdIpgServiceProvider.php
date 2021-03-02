<?php

namespace Bahramn\EcdIpg;

use Bahramn\EcdIpg\Payment\PaymentManagerInterface;
use Bahramn\EcdIpg\Payment\PaymentManager;
use Bahramn\EcdIpg\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

/**
 * @package Bahramn\EcdIpg
 */
class EcdIpgServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentManagerInterface::class, PaymentManager::class);
        $this->app->singleton(TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__. '/../config/ecd-ipg.php' => config_path('ecd-ipg.php'),
            __DIR__. '../resources/lang' => resource_path('lang/vendor/ecd-gateway')
        ]);
        $this->loadTranslationsFrom(__DIR__. '../resources/lang', 'ecd-ipg');
    }
}
