<?php

namespace App\Http\Controllers;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Services\Base\MailjetV3Service;
use App\Templates\Confirmation;
use Mailjet\Resources;

class MailTestController extends Controller
{
    protected $mjV31;
    protected $mjV3;

    /**
     * Create a new controller instance.
     *
     * @param MailTransactionalContract $mjV31
     * @param MailCommonContract $mjV3
     */
    public function __construct(MailTransactionalContract $mjV31, MailCommonContract $mjV3)
    {
        $this->mjV31 = $mjV31;
        $this->mjV3 = $mjV3;
    }
    public function testDependency()
    {
        var_dump($this->mjV31);
    }

    public function testSend()
    {
        $confirm = new Confirmation(['toEmail' => "duyang48484848@gmail.com", 'link' => "https://www.google.com", 'subject' => 'test subject', 'toName' => 'test name']);
        if($confirm->getError()){
           return $confirm->getError();
        }
        $body = $confirm->getBody();
        print_r($body);
        $body1 = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "duyang48484848@gmail.com",
                        'Name' => "Me"
                    ],
                    'To' => [
                        [
                            'Email' => "duyang48484848@gmail.com",
                            'Name' => "You"
                        ]
                    ],
                    'TemplateID' => 1064860,
                    'TemplateLanguage' => true,
                    'Subject' => "Account Confirm",
                    'Variables' => [
                         "firstname" =>  "Yang Du",
                         "link" =>  "www.google.com"
                    ]
                ]
            ]
        ];
        $response = $this->mjV31->getClient()->post(Resources::$Email, ['body' => $body]);
        print_r($response);exit;
        //$response->success() && var_dump($response->getData());
    }

    public function testGet()
    {
        $response = $this->mjV3->getClient()->get(Resources::$Message, ['id' => 1152921506578001004]);
        $response->success() && var_dump($response->getData());
    }
}
