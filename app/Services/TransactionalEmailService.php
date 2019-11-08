<?php

namespace App\Services;

use App\Templates\Confirmation;
use App\Templates\PriceAlert;
use App\Templates\ResetPassword;
use App\Templates\Welcome;
use App\Utils\Common;

class TransactionalEmailService
{
    use Common;

    public function sendAccountConfirmation(array $data)
    {
        $res = $this->sendWithTemplate(new Confirmation($data));
        return $res;
    }

    public function sendResetPassword(array $data)
    {
        $res = $this->sendWithTemplate(new ResetPassword($data));
        return $res;
    }

    public function sendPriceAlert(array $data)
    {
        $res = $this->sendWithTemplate(new PriceAlert($data));
        return $res;
    }

    public function sendWelcome(array $data)
    {
        $res = $this->sendWithTemplate(new Welcome($data));
        return $res;
    }

}
