<?php

namespace App\Services\Base;

use App\Contracts\MailTransactionalContract;
use Mailjet\Client;

class MailjetV31Service implements MailTransactionalContract
{
    private $client;

    /**
     * Create a new controller instance.
     *
     * @param $key
     * @param $secret
     * @param bool $call
     * @param array $settings
     */
    public function __construct($key, $secret, $call = true, array $settings = [])
    {
        $this->client = new Client($key, $secret, $call, $settings);
        $this->configClient();
    }

    public function configClient()
    {
        $this->client->setTimeout(100);
        $this->client->setConnectionTimeout(100);
    }
    public function getClient()
    {
        return $this->client;
    }


}
