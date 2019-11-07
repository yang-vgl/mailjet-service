<?php

namespace App\Utils;

use App\Contracts\LogContract;
use App\Contracts\MailTransactionalContract;
use App\Jobs\PiwikTrack;
use Mailjet\Resources;

trait Common
{
    protected $mjV31;
    protected $piwik;
    /**
     * @param MailTransactionalContract $mjV31
     * @param LogContract $piwik
     */
    public function __construct( MailTransactionalContract $mjV31, LogContract $piwik)
    {
        $this->mjV31 = $mjV31;
        $this->piwik = $piwik;
    }

    public function sendWithTemplate(Object $template)
    {
        if($template->getError()){
            $res = new Response(false, $template->getError());
            PiwikTrack::dispatch($this->piwik, $template->getSubject(), json_encode($template->getError()));
            return $res->format();
        }
        $body = $template->getBody();
        $response =  $this->mjV31->post(Resources::$Email, ['body' => $body]);
        PiwikTrack::dispatch($this->piwik, $template->getSubject(), json_encode($response->getResponse()));
        return $response->format();
    }

}
