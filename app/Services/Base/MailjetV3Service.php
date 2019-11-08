<?php

namespace App\Services\Base;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Utils\Response;
use Mailjet\Client;

class MailjetV3Service implements MailCommonContract
{
    private $_client;

    /**
     * Create a new controller instance.
     *
     * @param $key
     * @param $secret
     * @param bool  $call
     * @param array $settings
     */
    public function __construct($key, $secret, $call = true, array $settings = [])
    {
        $this->_client = new Client($key, $secret, $call, $settings);
        $this->configClient();
    }

    public function configClient()
    {
        $this->_client->setTimeout(100);
        $this->_client->setConnectionTimeout(100);
    }

    public function getClient()
    {
        return $this->_client;
    }

    public function post($resource, array $args = [], array $options = [])
    {
        try{
            $response = $this->_client->post($resource, $args, $options);
        }catch(\Exception $e){
            return (new Response(false, $e->getMessage()));
        }
        if (!$response->success()) {
            return (new Response(false, $response->getBody()));
        }
        return (new Response(true, '', $response->getData()));
    }

    public function get($resource, array $args = [], array $options = [])
    {
        try{
            $response = $this->_client->get($resource, $args, $options);
        }catch(\Exception $e){
            return (new Response(false, $e->getMessage()));
        }
        if (!$response->success()) {
            return (new Response(false, $response->getBody()));
        }
        return (new Response(true, '', $response->getData()));
    }

    public function put($resource, array $args = [], array $options = [])
    {
        try{
            $response = $this->_client->put($resource, $args, $options);
        }catch(\Exception $e){
            return (new Response(false, $e->getMessage()));
        }
        if (!$response->success()) {
            return (new Response(false, $response->getBody()));
        }
        return (new Response(true, '', $response->getData()));
    }


}
