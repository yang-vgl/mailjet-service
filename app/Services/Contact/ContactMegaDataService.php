<?php

namespace App\Services\Contact;

use App\Contracts\MailCommonContract;
use App\Models\ContactMetaData;
use App\Utils\Common;
use App\Utils\Response;
use Mailjet\Resources;

class ContactMegaDataService
{
    use Common;

    protected $mjV3;

    public function __construct(MailCommonContract $mjV3)
    {
        $this->mjV3 = $mjV3;
    }

    public function create($data)
    {
        $res =  ContactMetaData::validateCreate($data);
        if(!$res->getStatus()){
            return $res->format();
        }
        $res =  $this->mjV3->post(Resources::$Contactmetadata, ['body' => [
            'Datatype' => $data['dataType'],
            'Name' => $data['name'],
        ]]);
        return $res->format();
    }

    public function update($data)
    {
        $res =  ContactMetaData::validateUpdate($data);
        if(!$res->getStatus()){
            return $res->format();
        }
        $res = $this->mjV3->put(Resources::$Contactdata, ['id' =>$data['email'], 'body' =>[
            'Data' =>  $data['data']
        ]]);
        return $res->format();
    }

}
