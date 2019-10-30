<?php

namespace Shafimsp\SmsNotificationChannel\Contracts;

interface SmsMessage
{
    /**
     * Set the message driver.
     *
     * @param  string $driver
     * @return $this
     */
    public function via($driver);

    /**
     * Set the message content.
     *
     * @param  string $content
     * @return $this
     */
    public function content($content);

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string $from
     * @return $this
     */
    public function from($from);

    /**
     * Set the phone numbers, the message should be sent to.
     *
     * @param  string|array $to
     * @return $this
     */
    public function to($to);

    /**
     * Set the message type.
     *
     * @return $this
     */
    public function unicode();

    /**
     * Set the client reference (up to 40 characters).
     *
     * @param  string $clientReference
     * @return $this
     */
    public function clientReference($clientReference);

    /**
     * Send this message
     *
     */
    public function send();
}