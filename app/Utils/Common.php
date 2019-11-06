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
        //print_r($body);exit;
        $response =  $this->mjV31->post(Resources::$Email, ['body' => $body]);
        return $response->format();
    }

    public static function response($status, $msg='', $data='')
    {
        return json_encode([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
    }

}
