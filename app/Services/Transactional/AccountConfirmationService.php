<?php

namespace App\Services\Transactional;

use App\Contracts\LogContract;
use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use App\Utils\Common;
use Mailjet\Resources;

class AccountConfirmationService
{

    use Common;

    public function send(array $data)
    {
        $res = $this->sendWithTemplate(new Confirmation($data));
        return $res;
    }

}
