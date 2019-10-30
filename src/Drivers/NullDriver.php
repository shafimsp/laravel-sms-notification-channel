<?php

namespace Shafimsp\SmsNotificationChannel\Drivers;


use Shafimsp\SmsNotificationChannel\SmsMessage;

class NullDriver extends Driver
{

    /**
     * {@inheritdoc}
     */
    public function send(SmsMessage $message)
    {
        return $message;
    }

}