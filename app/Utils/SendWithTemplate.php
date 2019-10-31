<?php

namespace App\Utils;

use Mailjet\Resources;

trait SendWithTemplate
{
    public function sendWithTemplate(Object $template)
    {
        if($template->getError()){
            return $template->getError();
        }
        $body = $template->getBody();
        $response =  $this->mjV31->getClient()->post(Resources::$Email, ['body' => $body]);
        if($response->success()){
            return $response->getData();
        }else{
            return $response->getBody();
        }
    }
}
