<?php

namespace EmailManager\Providers;

use Drewm\MailChimp;
use Fungku\HubSpot\HubSpotService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MailChimp::class, function () {
            return new MailChimp(env('MAILCHIMP_API_KEY'));
        });

        $this->app->bind(HubSpotService::class, function () {
            return HubSpotService::make(env('HUBSPOT_API_KEY'));
        });
    }
}
