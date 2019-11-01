<?php

namespace App\Contracts;

interface MailTransactionalContract
{
    public function post($resource, array $args = [], array $options = []);

    public function get($resource, array $args = [], array $options = []);

    public function put($resource, array $args = [], array $options = []);

    public function delete($resource, array $args = [], array $options = []);

    public function getClient();

}
