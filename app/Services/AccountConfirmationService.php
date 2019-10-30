<?php

namespace App\Services;

use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use Mailjet\Resources;

class AccountConfirmationService
{
    protected $mjV31;

    /**
     * Create the event listener.
     * @param MailTransactionalContract $mjV31
     * @param Confirmation $template
     */
    public function __construct( MailTransactionalContract $mjV31)
    {
        $this->mjV31 = $mjV31;
    }

    public function send(array $data)
    {
        $confirm = new Confirmation($data);
        if($confirm->getError()){
            return $confirm->getError();
        }
        $body = $confirm->getBody();
        $response =  $this->mjV31->getClient()->post(Resources::$Email, ['body' => $body]);
        if($response->success()){
            return $response->getData();
        }else{
            return $response->getBody();
        }
    }

}
