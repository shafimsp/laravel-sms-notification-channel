<?php

namespace Shafimsp\SmsNotificationChannel;


use Illuminate\Log\LogManager;
use Illuminate\Support\Manager;
use Shafimsp\SmsNotificationChannel\Drivers\LogDriver;
use Nexmo\Client as NexmoClient;
use Nexmo\Client\Credentials\Basic as NexmoBasicCredentials;
use Shafimsp\SmsNotificationChannel\Drivers\NexmoDriver;
use Shafimsp\SmsNotificationChannel\Drivers\NullDriver;
use Psr\Log\LoggerInterface;

class SmsManager extends Manager
{

    /**
     * Get a driver instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }

    /**
     * Create a Nexmo SMS driver instance.
     *
     * @return \Shafimsp\SmsNotificationChannel\Drivers\NexmoDriver
     */
    public function createNexmoDriver()
    {
        return new NexmoDriver(
            $this->createNexmoClient(),
            $this->app['config']['sms.nexmo.from']
        );
    }

    /**
     * Create the Nexmo client.
     *
     * @return \Nexmo\Client
     */
    protected function createNexmoClient()
    {
        return new NexmoClient(
            new NexmoBasicCredentials(
                $this->app['config']['sms.nexmo.key'],
                $this->app['config']['sms.nexmo.secret']
            )
        );
    }

    /**
     * Create a Null SMS driver instance.
     *
     * @return \Shafimsp\SmsNotificationChannel\Drivers\NullDriver
     */
    public function createNullDriver()
    {
        return new NullDriver();
    }

    /**
     * Create a Null SMS driver instance.
     *
     * @return \Shafimsp\SmsNotificationChannel\Drivers\LogDriver
     */
    public function createLogDriver()
    {
        $logger = $this->app->make(LoggerInterface::class);

        if ($logger instanceof LogManager) {
            $logger = $logger->channel($this->app['config']['sms.log_channel']);
        }

        return new LogDriver($logger);
    }

    /**
     * Get the default SMS driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.default'] ?? 'null';
    }
}