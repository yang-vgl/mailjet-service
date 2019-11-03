<?php
namespace App\Models;
use App\Utils\Common;
use Illuminate\Support\Facades\Validator;

/**
 * Only email is required
 */
class Contact
{

    public static function validateUpdate($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required',
            'IsExcludedFromCampaigns'=> 'filled|boolean',
            'name'=> 'filled|string'
        ]);
        if ($validator->fails()) {
            return ['status' => false,  'msg' => $validator->errors()->getMessages()];
        }
        unset($data['id']);
        return ['status' => true, 'data' => $data];
    }

    public static function validateCreate($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'name' => 'filled|string',
            'isExcludedFromCampaigns' => 'filled|boolean',
        ]);
        if ($validator->fails()) {
            return ['status' => false,  'msg' => $validator->errors()->getMessages()];
        }
        return ['status' => true, 'data' => $data];
    }

}
