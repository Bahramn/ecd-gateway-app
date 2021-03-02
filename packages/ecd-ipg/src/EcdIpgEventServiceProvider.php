<?php

namespace Bahramn\EcdIpg;

use Bahramn\EcdIpg\Events\GatewayHttpRequestSent;
use Bahramn\EcdIpg\Events\GatewayHttpResponseReceived;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * @package Bahramn\EcdIpg
 */
class EcdIpgEventServiceProvider extends EventServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        GatewayHttpRequestSent::class => [
        ],
        GatewayHttpResponseReceived::class => [

        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
