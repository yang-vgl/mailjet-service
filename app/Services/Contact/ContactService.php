<?php

namespace App\Services\Contact;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Models\Contact;
use App\Templates\Confirmation;
use App\Templates\Welcome;
use App\Utils\SendWithTemplate;
use Mailjet\Resources;

class ContactService
{
    protected $mjV3;

    public function __construct(MailCommonContract $mjV3)
    {
        $this->mjV3 = $mjV3;
    }

    public function create($data)
    {
        $contact = new Contact($data);
        $res = $this->mjV3->getClient()->post(Resources::$Contact, ['body' => [
            'Email' =>  $contact->getEmail(),
            'Name'  =>  $contact->getName(),
            'IsExcludedFromCampaigns' =>  $contact->getIsExcludedFromCampaigns()
        ]]);
        //$res->getStatus()
        print_r($res);exit;
    }

    public function getAll()
    {
        $res = $this->mjV3->getClient()->get(Resources::$Contact);
        //$res->getStatus()
        print_r($res->getData());exit;
    }

    public function get($id)
    {
            $res = $this->mjV3->getClient()->get(Resources::$Contact, ['id' => $id]);
            print_r($res->getData());exit;
    }

    public function update($data)
    {

        $res = Contact::validateUpdate($data);
        if(!$res['status']){
            return $res;
        }
        $res = $this->mjV3->getClient()->put(Resources::$Contact, ['id' => $data['id'], 'body' => $res['data']]);
        print_r($res);exit;
    }

}
