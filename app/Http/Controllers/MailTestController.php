<?php

namespace App\Http\Controllers;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionnalContract;
use App\Services\Base\MailjetV3Service;
use Mailjet\Resources;

class MailTestController extends Controller
{
    protected $mjV31;
    protected $mjV3;

    /**
     * Create a new controller instance.
     *
     * @param MailTransactionnalContract $mjV31
     * @param MailCommonContract $mjV3
     */
    public function __construct(MailTransactionnalContract $mjV31, MailCommonContract $mjV3)
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
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "duyang48484848@gmail.com",
                        'Name' => "Me"
                    ],
                    'To' => [
                        [
                            'Email' => "duyanguk@163.com",
                            'Name' => "You"
                        ]
                    ],
                    'Subject' => "My first Mailjet Email!",
                    'TextPart' => "Greetings from Mailjet!",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3>
            <br />May the delivery force be with you!"
                ]
            ]
        ];
        $response = $this->mjV31->getClient()->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }

    public function testGet()
    {
        $response = $this->mjV3->getClient()->get(Resources::$Message, ['id' => 1152921506578001004]);
        $response->success() && var_dump($response->getData());
    }
}
