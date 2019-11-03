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
        if($response['status']){
            if($response['data']->success()){
                return $this->response(true, '', $response['data']->getData());
            }else{
                return $this->response(false, $response['data']->getBody());
            }
        }else{
            return $this->response(false, $response['msg']);
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

    public function formatResponse($res)
    {
        if(!$res['status']){
            return $this->response(false, $res['msg']);
        }
        if($res['data']->success()){
            return $this->response(true, '', $res['data']->getData());
        }else{
            return $this->response(false, $res['data']->getBody());
        }
    }

}
