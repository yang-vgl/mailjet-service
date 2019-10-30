<?php

namespace App\Templates;

use Illuminate\Support\Facades\Validator;

class Base
{
    protected $subject = null;

    protected $toEmail = null;

    protected $toName = 'Cruiser';

    protected $body = [];

    protected $variables = [];

    protected $error = [];

    public function baseInit($data)
    {
        $this->toEmail = $data['toEmail'];
        if(isset($data['toName']))
        {
            $this->toName = $data['toName'];
        }
        if(isset($data['subject']))
        {
            $this->subject = $data['subject'];
        }
    }

    public function setToEmail($toEmail) {
        $this->toEmail = $toEmail;
    }

    public function getToEmail() {
        return $this->toEmail;
    }

    public function setToName($toName) {
        $this->toName = $toName;
    }

    public function getToName($toName) {
        return $this->toName;
    }

    public function getError() {
        return $this->error;
    }

}
