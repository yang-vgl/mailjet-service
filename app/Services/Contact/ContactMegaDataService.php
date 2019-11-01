<?php

namespace App\Services\Contact;

use App\Contracts\MailCommonContract;
use App\Models\Contact;
use App\Models\ContactMetaData;
use Mailjet\Resources;

class ContactMegaDataService
{
    protected $mjV3;

    public function __construct(MailCommonContract $mjV3)
    {
        $this->mjV3 = $mjV3;
    }

    public function create($data)
    {
        $res =  ContactMetaData::validate($data);
        $res =  $this->mjV3->getClient()->post(Resources::$Contactmetadata, ['body' => [
            'Datatype' => $data['dataType'],
            'Name' => $data['name'],
        ]]);
        //$response->success() && var_dump($response->getData());
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
