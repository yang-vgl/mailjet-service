<?php

namespace App\Services;

use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use App\Templates\ResetPassword;
use App\Utils\Common;
use Mailjet\Resources;

class ResetPasswordService
{
    protected $mjV31;

    use Common;

    /**
     * @param MailTransactionalContract $mjV31
     */
    public function __construct( MailTransactionalContract $mjV31)
    {
        $this->mjV31 = $mjV31;
    }

    public function send(array $data)
    {
        $res = $this->sendWithTemplate(new ResetPassword($data));
        return $res;
    }

}
