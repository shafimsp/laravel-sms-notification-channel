<?php

namespace Shafimsp\SmsNotificationChannel\Drivers;


class NullDriver extends Driver
{

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        return [];
    }

}