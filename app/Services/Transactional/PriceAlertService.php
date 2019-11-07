<?php

namespace App\Services\Transactional;

use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use App\Templates\PriceAlert;
use App\Templates\ResetPassword;
use App\Utils\Common;
use Mailjet\Resources;

class PriceAlertService
{

    use Common;

    public function send(array $data)
    {
        $res = $this->sendWithTemplate(new PriceAlert($data));
        return $res;
    }

}
