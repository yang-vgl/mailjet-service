<?php

namespace App\Templates;

use Illuminate\Support\Facades\Validator;

class Welcome extends Base
{
    protected static $template_id = 1067803;

    protected $subject = 'Welcome Aboard !';

    public function __construct($data)
    {
        if($this->validate($data))
        {
            $this->baseInit($data);
        }
    }

    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'recipients.*.email' => 'required|email',
            'recipients.*.name' => 'filled|string',
        ]);
        if ($validator->fails()) {
            $this->error = $validator->errors()->getMessages();
            return false;
        }
        return true;
    }

    public function getBody() {
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
                'Variables' => [
                    'firstname' => $recipientName
                ]
            ];
        }
        $body = [
            'Messages' => $message
        ];
        return $body;
    }


}
