<?php

namespace Shafimsp\SmsNotificationChannel;


use Illuminate\Notifications\Notification;
use Shafimsp\SmsNotificationChannel\Drivers\Driver;

class SmsNotificationChannel
{
    /**
     * The driver instance.
     *
     * @var SmsManager
     */
    protected $sms;

    /**
     * SmsNotificationChannel constructor.
     * @param SmsManager $driver
     */
    public function __construct(SmsManager $driver)
    {
        $this->sms = $driver;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('sms', $notification)) {
            return;
        }

        $message = $notification->toSms($notifiable);

        if (is_string($message)) {
            $message = new SmsMessage($message);
        }

//        $message->send();
        $this->sms
            ->driver($message->driver)
            ->to($to)
            ->content($message->content)
            ->send();

        /*$this->events->fire(
            new NotificationFailed($notifiable, $notification, 'mobily-ws', $response)
        );*/
    }
}