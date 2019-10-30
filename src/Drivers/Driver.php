<?php

namespace Shafimsp\SmsNotificationChannel\Drivers;

use Shafimsp\SmsNotificationChannel\SmsMessage;

abstract class Driver
{
    /**
     * @param SmsMessage $message The message to send.
     * @return
     */
    abstract public function send(SmsMessage $message);

    /**
     * @return SmsMessage
     */
    private function newMessage()
    {
        return (new SmsMessage())->via($this);
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->newMessage()->$method(...$parameters);
    }
}