<?php

namespace App\Http\Controllers;

use App\Console\Commands\AccountConfirm;
use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Services\AccountConfirmationService;
use App\Services\Base\MailjetV3Service;
use App\Services\ResetPasswordService;
use App\Services\SyncTemplateService;
use App\Templates\Confirmation;
use Mailjet\Resources;

class MailTestController extends Controller
{
    protected $mjV31;
    protected $mjV3;
    protected $sync;

    /**
     * Create a new controller instance.
     *
     * @param MailTransactionalContract $mjV31
     * @param MailCommonContract $mjV3
     * @param ResetPasswordService $sync
     */
    public function __construct(MailTransactionalContract $mjV31, MailCommonContract $mjV3, ResetPasswordService $sync)
    {
        $this->mjV31 = $mjV31;
        $this->mjV3 = $mjV3;
        $this->sync = $sync;
    }
    public function testDependency()
    {
        var_dump($this->mjV31);
    }

    public function testSend()
    {
        $data = [
            'link' => "https://www.google.com",
            'subject' => 'test subject',
            'code' => 'ioj89rji3jf983jf983j9f',
            'recipients' =>[
                    'email' => 'duyanguk@163.com',
                    'name' => 'Yang'
            ]
        ];
        $res = $this->sync->send($data);
        print_r($res);exit;
        //event(new AccountCreate($data));exit;
//        $confirm = new Confirmation();
//        if($confirm->getError()){
//            return $confirm->getError();
//        }
//        $body = $confirm->getBody();
//        //print_r($body);exit;
        $body1 = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "info@cruisewatch.com",
                        'Name' => "Cruise Watch"
                    ],
                    'To' => [
                        [
                            'Email' => "duyanguk@163.com",
                            'Name' => "You"
                        ]
                    ],
                    'TemplateID' => 1066812,
                    'TemplateLanguage' => true,
                    'Subject' => "We have a new price alert for you",
                    'Variables' => [
                        "firstname" => "Cruiser",
                        "links"=> [
                            'details' => 'http://www.google.com',
                            "configure"=>"http://www.google.com",
                            "unsubscribe"=>"http://www.google.com"
                        ],
                        "alert" => [
                            "trip_name"=>"11",
                            "ship_name"=>"11",
                            "departure_date"=>"2019/12/12",
                            "prices"=> [
                                [
                                    'is_drop' => 1,
                                    'cabin_type' =>'1',
                                    'current' => 11,
                                    'change_abs' => 1,
                                    'change_rel' => 2,
                                    'updated_at' => '1',
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $response = $this->mjV31->getClient()->post(Resources::$Email, ['body' => $body1]);
        print_r($response);exit;
        $response->success() && var_dump($response->getData());
    }

    public function testGet()
    {
        $response = $this->mjV3->getClient()->get(Resources::$Message, ['id' => 1152921506578001004]);
        $response->success() && var_dump($response->getData());
    }

    public function testTemp()
    {
        $response = $this->mjV3->getClient()->get(Resources::$Template, ['id' => 850961]);
        print_r($response);exit;
        $response->success() && var_dump($response->getData());
    }
}
