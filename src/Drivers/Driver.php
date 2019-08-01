<?php

namespace Shafimsp\SmsNotificationChannel\Drivers;

use Shafimsp\SmsNotificationChannel\Exceptions\SmsException;
use Shafimsp\SmsNotificationChannel\SmsMessage;

abstract class Driver
{
    /**
     * The recipient of the message.
     *
     * @var string
     */
    protected $recipient;
    /**
     * The message to send.
     *
     * @var string
     */
    protected $message;

    /**
     * {@inheritdoc}
     */
    abstract public function send();

    /**
     * Set the recipient of the message.
     *
     * @param string  $recipient
     *
     * @throws \Shafimsp\SmsNotificationChannel\Exceptions\SmsException
     *
     * @return $this
     */
    public function to(string $recipient)
    {
        throw_if(is_null($recipient), SmsException::class, 'Recipients cannot be empty');
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * Set the content of the message.
     *
     * @param string  $message
     *
     * @throws \Shafimsp\SmsNotificationChannel\Exceptions\SmsException
     *
     * @return $this
     */
    public function content(string $message)
    {
        throw_if(empty($message), SmsException::class, 'Message text is required');
        $this->message = $message;
        return $this;
    }
}