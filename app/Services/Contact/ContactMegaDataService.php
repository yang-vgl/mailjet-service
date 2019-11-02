<?php

namespace App\Services\Contact;

use App\Contracts\MailCommonContract;
use App\Models\Contact;
use App\Models\ContactMetaData;
use App\Utils\Common;
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
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        $res =  $this->mjV3->post(Resources::$Contactmetadata, ['body' => [
            'Datatype' => $data['dataType'],
            'Name' => $data['name'],
        ]]);
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        return $this->response($res[0], '', $res[1]->getData());
    }

    public function update($data)
    {
        $res =  ContactMetaData::validateUpdate($data);
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        $res = $this->mjV3->put(Resources::$Contactdata, ['id' =>$data['email'], 'body' =>[
            'Data' =>  $data['data']
        ]]);
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        return $this->response($res[0], '', $res[1]->getData());
    }

}
