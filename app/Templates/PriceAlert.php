<?php

namespace App\Templates;

use Illuminate\Support\Facades\Validator;

class PriceAlert extends Base
{
    protected static $template_id = 1066812;

    protected $subject = 'Price Alert';

    protected $code = null;

    protected $link = null;

    public function __construct($data)
    {
        if($this->validate($data)) {
            $this->baseInit($data);
            $this->init($data);
        }
    }

    public function validate(array $data)
    {
        $validator = Validator::make(
            $data, [
            'recipients.*.email' => 'required|email',
            'recipients.*.name' => 'filled|string',
            'fromEmail' => 'filled|email',
            'fromName' => 'filled|string',
            'links.details' => 'required|url',
            'links.configure' => 'required|url',
            'links.unsubscribe' => 'required|url',
            'alert.trip_name' => 'required',
            'alert.ship_name' => 'required',
            'alert.departure_date' => 'required|date',
            'alert.prices.*.is_drop' => 'required|boolean',
            'alert.prices.*.cabin_type' => 'required',
            'alert.prices.*.current' => 'required|numeric',
            'alert.prices.*.change_abs' => 'required|numeric',
            'alert.prices.*.change_rel' => 'required|numeric',
            'alert.prices.*.updated_at' => 'required|date',
            ]
        );
        if ($validator->fails()) {
            $this->error = $validator->errors()->getMessages();
            return false;
        }
        return true;
    }

    public function init($data)
    {
        $this->variables = [
            "alert" =>  $data['alert'],
            "links" =>  $data['links']
        ];
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->$link = $link;
    }

    public function getBody()
    {
        foreach($this->recipients as $recipient){
            $recipientName = isset($recipient['name']) ? $recipient['name'] : $this->firstName;
            $message[] = [
                    'From' => [
                        'Email' => $this->fromEmail,
                        'Name' => $this->fromName
                    ],
                    'To' => [
                        [
                            'Email' => $recipient['email'],
                            'Name' => $recipientName
                        ]
                    ],
                    'TemplateID' => self::$template_id,
                    'TemplateLanguage' => true,
                    'Subject' => $this->subject,
                    'Variables' => array_merge($this->variables, ['firstname' => $recipientName])
            ];
        }
        $body = [
            'Messages' => $message
        ];
        return $body;
    }


}
