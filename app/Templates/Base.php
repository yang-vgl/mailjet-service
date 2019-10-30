<?php

namespace App\Templates;

class Base
{
    protected $subject = null;

    protected $fromEmail = null;

    protected $fromName = null;

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
        if(isset($data['fromName']))
        {
            $this->fromName = $data['fromName'];
        }else{
            $this->fromName = config('services.mailjet.From.Name');
        }
        if(isset($data['fromEmail']))
        {
            $this->fromEmail = $data['fromEmail'];
        }else{
            $this->fromName = config('services.mailjet.From.Email');
        }
        if(isset($data['subject']))
        {
            $this->subject = $data['subject'];
        }
    }

    public function getToEmail() {
        return $this->toEmail;
    }

    public function setToEmail($toEmail) {
        $this->toEmail = $toEmail;
    }

    public function getToName($toName) {
        return $this->toName;
    }

    public function setToName($toName) {
        $this->toName = $toName;
    }

    public function getError() {
        return $this->error;
    }

}
