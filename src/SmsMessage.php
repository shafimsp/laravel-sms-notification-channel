<?php

namespace Shafimsp\SmsNotificationChannel;

use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Shafimsp\SmsNotificationChannel\Contracts\SmsMessage as SmsMessageContract;
use Shafimsp\SmsNotificationChannel\Drivers\Driver;
use Shafimsp\SmsNotificationChannel\Exceptions\SmsNotificationException;
use Shafimsp\SmsNotificationChannel\Facades\Sms;

class SmsMessage implements SmsMessageContract, Arrayable, Jsonable, JsonSerializable
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
     * The phone numbers, the message should be sent to.
     *
     * @var array
     */
    public $to = [];

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
     * The extra request params.
     *
     * @var array
     */
    public $extra = [];


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
     * @param  string $driver
     * @return $this
     */
    public function via($driver)
    {
        $this->driver = $driver;

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
     * @internal
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the phone numbers, the message should be sent to.
     *
     * @param  string|array $to
     * @return $this
     */
    public function to($to)
    {
        $this->to = array_merge($this->to, is_string($to) ? func_get_args() : $to);

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
        $this->throwIf(empty($this->to), new SmsNotificationException('Recipients cannot be empty'));
        $this->throwIf(empty($this->content), new SmsNotificationException('Message text is required'));

        return $this->driver()->send($this);
    }

    /**
     * Convert the SmsMessage instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge([
            'driver' => $this->driver,
            'content' => $this->content,
            'from' => $this->from,
            'to' => $this->to,
            'type' => $this->type,
            'client_reference' => $this->clientReference,
        ], $this->extra);
    }

    /**
     * Convert the SmsMessage instance to JSON.
     *
     * @param  int $options
     * @return string
     *
     * @throws SmsNotificationException
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        $this->throwIf(JSON_ERROR_NONE !== json_last_error(), new SmsNotificationException('Error encoding SmsMessage to JSON: ' . json_last_error_msg()));

        return $json;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Handle dynamic method calls into the message.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (count($parameters) > 0) {
            $this->extra[$method] = count($parameters) == 1 ? $parameters[0] : $parameters;
        }

        return $this;
    }

    /**
     * Handle dynamic setter into the message.
     *
     * @param  string $name
     * @param  $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        $this->extra[$name] = $value;
    }

    /**
     * Handle dynamic getter for extras in the message.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->extra[$name] ?? null;
    }

    private function driver()
    {
        if ($this->driver instanceof Driver) {
            return $this->driver;
        }

        return Sms::driver($this->driver);
    }

    private function throwIf($boolean, $exception, $message = '')
    {
        if ($boolean) {
            throw (is_string($exception) ? new $exception($message) : $exception);
        }
    }
}