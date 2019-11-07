<?php

namespace App\Utils;

use Mailjet\Resources;

trait Common
{
    public function sendWithTemplate(Object $template)
    {
        if($template->getError()){
            $res = new Response(false, $template->getError());
            return $res->format();
        }
        $body = $template->getBody();
        $response =  $this->mjV31->post(Resources::$Email, ['body' => $body]);
        return $response->format();
    }

}
