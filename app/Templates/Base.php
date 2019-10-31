<?php

namespace App\Templates;

class Base
{
    protected $subject = null;

    protected $fromEmail = null;

    protected $fromName = null;

    protected $recipients = [];

    protected $body = [];

    protected $variables = [];

    protected $error = [];

    protected $firstName = 'cruiser';

    public function baseInit($data)
    {

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
            $this->fromEmail = config('services.mailjet.From.Email');
        }
        if(isset($data['subject']))
        {
            $this->subject = $data['subject'];
        }
        $this->recipients = $data['recipients'];

    }

    public function getError() {
        return $this->error;
    }

}
