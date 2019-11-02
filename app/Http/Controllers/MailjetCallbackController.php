<?php

namespace App\Http\Controllers;

use App\Console\Commands\AccountConfirm;
use App\Contracts\MailCommonContract;
use App\Contracts\MailTransactionalContract;
use App\Events\AccountCreate;
use App\Events\PriceChange;
use App\Services\AccountConfirmationService;
use App\Services\Base\MailjetV3Service;
use App\Services\Contact\ContactMegaDataService;
use App\Services\Contact\ContactService;
use App\Services\ResetPasswordService;
use App\Templates\Confirmation;
use App\Utils\Common;
use Illuminate\Http\Request;
use Mailjet\Resources;

class MailjetCallbackController extends Controller
{
    public function callBack(Request $request)
    {
        //todo handle callback data
        print_r($request->all());
        exit;
    }

    public function test(Request $request)
    {
        //todo handle callback data
        print_r($request->all());
        exit;
    }

}
