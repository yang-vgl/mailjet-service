<?php
namespace App\Utils;

class Response
{
    protected $status;
    protected $error;
    protected $response;

    public function __construct($status, $error = '', $response = [])
    {
        $this->status = $status;
        $this->error = $error;
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function format()
    {
        return json_encode([
            'status' =>  $this->status,
            'msg' => $this->error,
            'data' => $this->response
        ]);
    }

}
