<h2 align="center">
     SMS Notification Channel for Laravel
</h2>

## Introduction

This package makes it easy to send SMS notifications using different SMS provider with Laravel.

Installation
------------

To install the PHP client library using Composer:

```bash
composer require shafimsp/sms-notification-channel
```

The package will automatically register itself.

Configuration
-------------

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Shafimsp\SmsNotificationChannel\SmsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | The default SMS Driver
    |--------------------------------------------------------------------------
    |
    | The default sms driver to use as a fallback when no driver is specified
    | while using the SMS.
    |
    | Supported: "nexmo", "log", "null"
    |
    */
    'default' => env('SMS_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Nexmo Driver Configuration
    |--------------------------------------------------------------------------
    |
    | We specify key, secret, and the number messages will be sent from.
    |
    */
    'nexmo' => [
        'key' => env('NEXMO_KEY', ''),
        'secret' => env('NEXMO_SECRET', ''),
        'from' => env('NEXMO_SMS_FROM', '')
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channel
    |--------------------------------------------------------------------------
    |
    | If you are using the "log" driver, you may specify the logging channel
    | if you prefer to keep mail messages separate from other log entries
    | for simpler reading. Otherwise, the default channel will be used.
    |
    */
    'log_channel' => env('SMS_LOG_CHANNEL'),
];
```

Usage
-------------

### Notification

Set `sms` channel in `via` method on notification class

```php
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['sms'];
    }
```

and define a toSms method on the notification class.

```php
    /**
     * Get the SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toSms()
    {
        return 'Your message content goes here';
    }
```

Or


```php
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toSms()
    {
        return (new SmsMessage())
            ->content('Your message goes here');
    }
```

#### Unicode Content
If your SMS message will contain unicode characters, you should call the unicode method when constructing the SmsMessage instance:

```php
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toSms()
    {
        return (new SmsMessage())
            ->content('Your message goes here')
            ->unicode();
    }
```

#### Customizing The "From" Number
If you would like to send some notifications from a phone number that is different from the phone number specified in your config/services.php file, you may use the from method on a SmsMessage instance:

```php
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toSms()
    {
        return (new SmsMessage())
            ->content('Your message goes here')
            ->unicode();
    }
```

#### Routing SMS Notifications
When sending notifications via the `sms` channel, you should define a routeNotificationForSms method on the entity:

```php
     /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSms($notification)
    {
        return $this->phone;
    }
```

### Direct method
```php
\Shafimsp\SmsNotificationChannel\Facades\Sms::driver('nexmo')
        ->content("Message content goes here")
        ->to('MOBILE_NUMBER_TO_SENT_TO')
        ->send();
```


## Security

If you discover any security related issues, please email shafimsp@gmail.com instead of using the issue tracker.


## License

Laravel SMS Notification Channel is open-sourced software licensed under the [MIT license](LICENSE.md).
