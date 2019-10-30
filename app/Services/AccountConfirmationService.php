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
    protected $mjV31;

    /**
     * Create the event listener.
     * @param AccountConfirmationService $service
     * @param MailTransactionalContract $mjV31
     */
    public function __construct( MailTransactionalContract $mjV31)
    {
        $this->mjV31 = $mjV31;
    }

    public function send(array $data)
    {
        //['toEmail' => "duyang48484848@gmail.com", 'link' => "https://www.google.com", 'subject' => 'test subject', 'toName' => 'test name']
        $confirm = new Confirmation($data);
//        if($confirm->getError()){
//            return $confirm->getError();
//        }
        $body = $confirm->getBody();
        //print_r($body);exit;
        $response =  $this->mjV31->getClient()->post(Resources::$Email, ['body' => $body]);
        if($response->success()){
            return $response->getData();
        }else{
            return $response->getBody();
        }
    }

}
