<?php

namespace App\Templates;

use Illuminate\Support\Facades\Validator;

class Confirmation extends Base
{
    protected static $template_id = 1064860;

    protected $subject = 'Account Confirm';

    protected $link = null;


    public function __construct($data)
    {
        $this->validate($data);
        $this->baseInit($data);
        $this->init($data);
    }

    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'toEmail' => 'required|email',
            'link' => 'required|url',
        ]);
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return;
        }
    }

    public function init($data)
    {
        $this->link = $data['link'];
        $this->variables = [
            "firstname" =>  $this->toName,
            "link" =>  $this->link
        ];
    }

    public function setLink($link) {
        $this->$link = $link;
    }

    public function getLink() {
        return $this->link;
    }

    public function getBody() {
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "duyang48484848@gmail.com",
                        'Name' => "Me"
                    ],
                    'To' => [
                        [
                            'Email' =>  $this->toEmail,
                            'Name' => $this->toName
                        ]
                    ],
                    'TemplateID' => self::$template_id,
                    'TemplateLanguage' => true,
                    'Subject' => $this->subject,
                    'Variables' => $this->variables
                ]
            ]
        ];
        return $body;
    }



}
