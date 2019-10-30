<?php

namespace App\Services;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use Illuminate\Support\ServiceProvider;
use Mailjet\Client;
use Mailjet\Resources;

class AccountConfirmationService
{

    public function send(MailTransactionalContract $mjV31, array $data)
    {
        //['toEmail' => "duyang48484848@gmail.com", 'link' => "https://www.google.com", 'subject' => 'test subject', 'toName' => 'test name']
        $confirm = new Confirmation($data);
        if($confirm->getError()){
            return $confirm->getError();
        }
        $body = $confirm->getBody();
        //print_r($body);exit;
        $response = $mjV31->getClient()->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }

}
