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
        if(!$res['status']){
            return $this->response(false, $res['msg']);
        }
        $res = $this->mjV3->post(Resources::$Contact, ['body' => [
            'Email' =>  $data['email'],
            'Name'  =>  isset($data['email']) ? $data['email'] : '',
            'IsExcludedFromCampaigns' => isset($data['IsExcludedFromCampaigns']) ? $data['IsExcludedFromCampaigns'] : true
        ]]);
        return $this->formatResponse($res);
    }

    public function getAll()
    {
        $res = $this->mjV3->get(Resources::$Contact);
        return $this->formatResponse($res);

    }

    public function get($id)
    {
        $res = $this->mjV3->get(Resources::$Contact, ['id' => $id]);
        return $this->formatResponse($res);
    }

    public function update($data)
    {
        $res = Contact::validateUpdate($data);
        if(!$res['status']){
            return $this->response(false, $res['msg']);
        }
        $res = $this->mjV3->put(Resources::$Contact, ['id' => $data['id'], 'body' => $res[1]]);
        return $this->formatResponse($res);
    }



}
