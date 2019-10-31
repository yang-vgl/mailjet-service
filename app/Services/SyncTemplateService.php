<?php

namespace App\Services;

use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Templates\Confirmation;
use Illuminate\Support\Facades\Redis;
use Mailjet\Resources;

class SyncTemplateService
{
    protected $mjV31;
    protected $mjV3;

    /**
     * Create the event listener.
     * @param MailTransactionalContract $mjV31
     * @param MailCommonContract $mjV3
     */
    public function __construct( MailTransactionalContract $mjV31, MailCommonContract $mjV3)
    {
        $this->mjV31 = $mjV31;
        $this->mjV3 = $mjV3;
    }

    public function sync($templateId, $template)
    {
        //account create confirm
        $response =  $this->mjV3->getClient()->get(Resources::$TemplateDetailcontent, ['id' => 1066651]);
        print_r($response);exit;
        //$response->success() && var_dump($response->getData());
        Redis::set('account_confirm', json_encode($response->getData()));
        //print_r(Redis::get('account_confirm'));exit;
        $body = [
            'Author' => "John Doe",
            'Categories' => [],
            'Copyright' => "Mailjet",
            'Description' => "Used to send out promo codes.",
            'EditMode' => 1,
            'IsStarred' => false,
            'IsTextPartGenerationEnabled' => true,
            'Locale' => "en_US",
            'Name' => "Promo Codes 1",
            'OwnerType' => "user",
            'Presets' => "string",
        ];
        $response = $this->mjV3->getClient()->post(Resources::$Template, [ 'body' => $body]);
        print_r($response);exit;
        $response = $this->mjV31->getClient()->post(Resources::$TemplateDetailcontent, [ 'body' => $response->getData()]);
        print_r($response);exit;
    }

}
