<?php

namespace Shafimsp\SmsNotificationChannel\Facades;

use Illuminate\Support\Facades\Facade;
use Shafimsp\SmsNotificationChannel\SmsManager;

/**
 * Class Sms
 * @method static \Shafimsp\SmsNotificationChannel\Drivers\Driver driver(string $name = null)
 * @see \Shafimsp\SmsNotificationChannel\SmsManager
 */
class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }

}