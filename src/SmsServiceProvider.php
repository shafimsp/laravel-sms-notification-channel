<?php

namespace Shafimsp\SmsNotificationChannel;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/sms.php', 'sms');
        }

        $this->app->singleton('sms', function ($app) {
            return new SmsManager($app);
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('sms', function ($app) {
                return new SmsNotificationChannel(
                    $this->app->make('sms')
                );
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->offerPublishing();
    }

    /**
     * Setup the resource publishing groups for Passport.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/sms.php' => config_path('sms.php'),
            ], 'sms-config');
        }
    }

}
