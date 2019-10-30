<?php

namespace Shafimsp\SmsNotificationChannel\Facades;

use Illuminate\Support\Facades\Facade;
use Shafimsp\SmsNotificationChannel\SmsManager;

/**
 * @method static \Shafimsp\SmsNotificationChannel\Drivers\Driver driver(string $name = null)
 * @method static \Shafimsp\SmsNotificationChannel\Contracts\SmsMessage via(string $driver = null)
 * @method static \Shafimsp\SmsNotificationChannel\Contracts\SmsMessage content(string $content)
 * @method static \Shafimsp\SmsNotificationChannel\Contracts\SmsMessage to($to)
 * @method static \Shafimsp\SmsNotificationChannel\Contracts\SmsMessage unicode()
 * @method static \Shafimsp\SmsNotificationChannel\Contracts\SmsMessage clientReference($clientReference)
 * @method static send()
 *
 * @see \Shafimsp\SmsNotificationChannel\Contracts\SmsMessage
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