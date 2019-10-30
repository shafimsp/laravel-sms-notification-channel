<?php

namespace Shafimsp\SmsNotificationChannel;


use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Notification;

class SmsNotificationChannel
{
    /**
     * The driver instance.
     *
     * @var SmsManager
     */
    protected $sms;

    /** @var Dispatcher */
    private $events;

    /**
     * SmsNotificationChannel constructor.
     * @param SmsManager $driver
     * @param Dispatcher $events
     */
    public function __construct(SmsManager $driver, Dispatcher $events)
    {
        $this->sms = $driver;
        $this->events = $events;
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

        $message->to($to);

        $this->events->dispatch(
            new NotificationSending($notifiable, $notification, 'sms.'.$message->driver)
        );

        try {
            $response = $this->sms
                ->driver($message->driver)
                ->send($message);

            $this->events->dispatch(
                new NotificationSent($notifiable, $notification, 'sms.'.$message->driver, $response)
            );
        } catch (Exception $e) {
            $this->events->dispatch(
                new NotificationFailed($notifiable, $notification, 'sms.'.$message->driver, $e)
            );
        }
    }
}