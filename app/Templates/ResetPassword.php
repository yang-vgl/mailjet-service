<?php

namespace App\Templates;

use Illuminate\Support\Facades\Validator;

class ResetPassword extends Base
{
    protected static $template_id = 852568;

    protected $subject = 'Reset Password';

    protected $code = null;

    protected $link = null;

    public function __construct($data)
    {
        if($this->validate($data))
        {
            $this->baseInit($data);
            $this->init($data);
        }
    }

    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'recipients.email' => 'required|email',
            'code' => 'required',
            'link' => 'required|url',
        ]);
        if ($validator->fails()) {
            $this->error = $validator->errors()->getMessages();
            return false;
        }
        return true;
    }

    public function init($data)
    {
        $this->variables = [
            "code" =>  $data['code'],
            "link" =>  $data['link']
        ];
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->$link = $link;
    }

    public function getBody() {
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->fromEmail,
                        'Name' => $this->fromName
                    ],
                    'To' => [$this->recipients],
                    'TemplateLanguage' => true,
                    'Subject' => $this->subject,
                    'Variables' =>$this->variables,
                    'TemplateID' => self::$template_id
                ]
            ]
        ];
        return $body;
    }


}
