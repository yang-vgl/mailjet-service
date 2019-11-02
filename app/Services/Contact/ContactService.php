<?php

namespace App\Services\Contact;

use App\Contracts\MailCommonContract;
use App\Models\Contact;
use App\Utils\Common;
use Mailjet\Resources;

class ContactService
{
    use Common;

    protected $mjV3;

    public function __construct(MailCommonContract $mjV3)
    {
        $this->mjV3 = $mjV3;
    }

    public function create($data)
    {
        $res = Contact::validateCreate($data);
        if(!$res[0]){
            return self::response(false, $res[1]);
        }
        $res = $this->mjV3->post(Resources::$Contact, ['body' => [
            'Email' =>  $data['email'],
            'Name'  =>  isset($data['email']) ? $data['email'] : '',
            'IsExcludedFromCampaigns' => isset($data['IsExcludedFromCampaigns']) ? $data['IsExcludedFromCampaigns'] : true
        ]]);
        return $this->response($res[0], $res[1]);
    }

    public function getAll()
    {
        $res = $this->mjV3->get(Resources::$Contact);
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        return $this->response($res[0], '', $res[1]->getData());
    }

    public function get($id)
    {
        $res = $this->mjV3->get(Resources::$Contact, ['id' => $id]);
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        return $this->response($res[0], '', $res[1]->getData());
    }

    public function update($data)
    {
        $res = Contact::validateUpdate($data);
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        $res = $this->mjV3->put(Resources::$Contact, ['id' => $data['id'], 'body' => $res[1]]);
        if(!$res[0]){
            return $this->response(false, $res[1]);
        }
        return $this->response($res[0], '', $res[1]->getData());
    }



}
