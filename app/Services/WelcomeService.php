<?php

namespace App\Services;

use App\Contracts\MailTransactionalContract;
use App\Templates\Welcome;
use App\Utils\Common;

class WelcomeService
{
    protected $mjV31;

    use Common;

    /**
     * Create the event listener.
     * @param MailTransactionalContract $mjV31
     */
    public function __construct( MailTransactionalContract $mjV31)
    {
        $this->mjV31 = $mjV31;
    }

    public function send(array $data)
    {
        $res = $this->sendWithTemplate(new Welcome($data));
        return $res;
    }

}
