<?php

namespace App\Services\Base;

use App\Contracts\MailTransactionalContract;
use Mailjet\Client;
use Mailjet\Response;

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

    /**
     * Trigger a POST request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function post($resource, array $args = [], array $options = [])
    {
        $response = $this->client->post($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:post() failed", $response);
        }
        return $response;
    }
    /**
     * Trigger a GET request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function get($resource, array $args = [], array $options = [])
    {
        $response = $this->client->get($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:get() failed", $response);
        }
        return $response;
    }
    /**
     * Trigger a PUT request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function put($resource, array $args = [], array $options = [])
    {
        $response = $this->client->put($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:put() failed", $response);
        }
        return $response;
    }
    /**
     * Trigger a DELETE request
     *
     * @param array $resource Mailjet Resource/Action pair
     * @param array $args     Request arguments
     * @param array $options
     *
     * @return Response
     */
    public function delete($resource, array $args = [], array $options = [])
    {
        $response = $this->client->delete($resource, $args, $options);
        if (!$response->success()) {
            $this->throwError("MailjetService:delete() failed", $response);
        }
        return $response;
    }


}
