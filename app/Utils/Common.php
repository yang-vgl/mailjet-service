<?php

namespace App\Utils;

use Mailjet\Resources;

trait Common
{
    public function sendWithTemplate(Object $template)
    {
        if($template->getError()){
            return $this->response(false, $template->getError());
        }
        $body = $template->getBody();
        //print_r($body);exit;
        $response =  $this->mjV31->post(Resources::$Email, ['body' => $body]);
        if($response->success()){
            return $this->response(true, '', $response->getData());
        }else{
            return $this->response(false, $response->getBody());
        }
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
