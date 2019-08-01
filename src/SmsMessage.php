<?php

namespace Shafimsp\SmsNotificationChannel;

use Illuminate\Support\Facades\Storage;
use Shafimsp\SmsNotificationChannel\Facades\Sms;

class SmsMessage
{
    /**
     * The message driver.
     *
     * @var string
     */
    public $driver = null;

    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $to;

    /**
     * The message type.
     *
     * @var string
     */
    public $type = 'text';

    /**
     * The client reference.
     *
     * @var string
     */
    public $clientReference = '';

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message driver.
     *
     * @param  string  $diver
     * @return $this
     */
    public function driver($diver)
    {
        $this->driver = $diver;
        return $this;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Set the phone number the message should be sent to.
     *
     * @param  string  $to
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Set the message type.
     *
     * @return $this
     */
    public function unicode()
    {
        $this->type = 'unicode';
        return $this;
    }

    /**
     * Set the client reference (up to 40 characters).
     *
     * @param  string  $clientReference
     * @return $this
     */
    public function clientReference($clientReference)
    {
        $this->clientReference = $clientReference;
        return $this;
    }

    /**
     * Send this message
     *
     */
    public function send()
    {
//        Sms::driver($this->driver)->send($this);
    }
}