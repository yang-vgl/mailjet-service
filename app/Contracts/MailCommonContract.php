<?php

namespace App\Contracts;

interface MailCommonContract
{
    public function getClient();

    public function post($resource, array $args = [], array $options = []);

    public function get($resource, array $args = [], array $options = []);

    public function put($resource, array $args = [], array $options = []);

}
