<?php

namespace App\Services\Transactional;

use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use App\Templates\ResetPassword;
use App\Utils\Common;
use Mailjet\Resources;

class ResetPasswordService
{

    use Common;

    public function send(array $data)
    {
        $res = $this->sendWithTemplate(new ResetPassword($data));
        return $res;
    }

}
