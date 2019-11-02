<?php
namespace App\Models;
use App\Utils\Common;
use Illuminate\Support\Facades\Validator;

/**
 * Only email is required
 */
class Contact
{

//    public static function validateGet($id)
//    {
//        $validator = Validator::make([$id], [
//            'id' => 'required|integer',
//        ]);
//        if ($validator->fails()) {
//            return [false,  $validator->errors()->getMessages()];
//        }
//        return ['status' => true];
//    }

    public static function validateUpdate($data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'IsExcludedFromCampaigns'=> 'filled|boolean',
            'name'=> 'filled|string'
        ]);
        if ($validator->fails()) {
            return [false,  $validator->errors()->getMessages()];
        }
        unset($data['id']);
        return [true, $data];
    }

    public static function validateCreate($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'name' => 'filled|string',
            'isExcludedFromCampaigns' => 'filled|boolean',
        ]);
        if ($validator->fails()) {
            return [false,  $validator->errors()->getMessages()];
        }
        return [true, ''];
    }

}
