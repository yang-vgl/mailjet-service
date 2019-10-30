<?php

namespace App\Templates;

use Illuminate\Support\Facades\Validator;

class Confirmation
{
    protected static $id = 1064860;

    protected $subject = 'Account Confirm';

    protected $content = null;

    protected $toEmail = null;

    protected $toName = 'Cruiser';

    protected $link = null;

    protected $body = [];

    protected $error = [];

    public function __construct($data)
    {
        $this->validate($data);
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
        $this->toEmail = $data['toEmail'];
        $this->link = $data['link'];
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

    public function setLink($link) {
        $this->$link = $link;
    }

    public function getLink() {
        return $this->link;
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
                    'TemplateID' => self::$id,
                    'TemplateLanguage' => true,
                    'Subject' => $this->subject,
                    'Variables' => [
                        "firstname" =>  $this->toName,
                        "link" =>  $this->link
                    ]
                ]
            ]
        ];
        return $body;
    }



}
