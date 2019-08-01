<?php

namespace Shafimsp\SmsNotificationChannel\Drivers;


use Psr\Log\LoggerInterface;

class LogDriver extends Driver
{

    /**
     * The Logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * LogDriver constructor.
     *
     * Create a new log transport instance.
     *
     * @param  \Psr\Log\LoggerInterface  $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $this->logger->info("SMS: $this->recipient -> ".trim($this->message));
    }
}