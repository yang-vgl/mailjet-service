<?php

namespace App\Services\Transactional;

use App\Contracts\MailTransactionalContract;
use App\Templates\Welcome;
use App\Utils\Common;

class WelcomeService
{

    use Common;

    public function send(array $data)
    {
        $res = $this->sendWithTemplate(new Welcome($data));
        return $res;
    }

}
