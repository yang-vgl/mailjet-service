<?php

namespace App\Http\Controllers;

use App\Console\Commands\AccountConfirm;
use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Events\PriceChange;
use App\Libraries\PiwikTracker;
use App\Services\Transactional\AccountConfirmationService;
use App\Services\Base\MailjetV3Service;
use App\Services\Contact\ContactListService;
use App\Services\Contact\ContactMegaDataService;
use App\Services\Contact\ContactService;
use App\Services\Transactional\ResetPasswordService;
use App\Templates\Confirmation;
use App\Utils\Common;
use Illuminate\Http\Request;
use Mailjet\Resources;

class PiwikTestController extends Controller
{
    protected $mjV31;
    protected $mjV3;
    protected $sync;
    protected $contact;

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

    public function testPiwik()
    {
       $piwik = new PiwikTracker(1);
       // $res = $piwik->doTrackEvent('transactional', 'Account Confirm', 'succdassssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssess', 1);
        $res = $piwik->doTrackContentImpression('Account Confirm', 'success');
        print_r($res);exit;
    }


}
