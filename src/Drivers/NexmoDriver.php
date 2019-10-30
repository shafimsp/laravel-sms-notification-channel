<?php

namespace Shafimsp\SmsNotificationChannel\Drivers;

use Nexmo\Client as NexmoClient;
use Shafimsp\SmsNotificationChannel\SmsMessage;

class NexmoDriver extends Driver
{

    /**
     * The Nexmo client.
     *
     * @var \Nexmo\Client
     */
    protected $client;

    /**
     * The phone number this sms should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new Nexmo driver instance.
     *
     * @param  \Nexmo\Client  $nexmo
     * @param  string  $from
     */
    public function __construct(NexmoClient $nexmo, $from)
    {
        $this->client = $nexmo;
        $this->from = $from;
    }

    /**
     * {@inheritdoc}
     */
    public function send(SmsMessage $message)
    {
        return $this->client->message()->send([
            'type' => $message->type,
            'from' => $this->from,
            'to' => $message->to,
            'text' => trim($message->content)
        ]);
    }
}