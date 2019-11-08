<?php
namespace App\Models;
use App\Utils\Common;
use App\Utils\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Only email is required
 */
class Contact
{

    public static function validateUpdate($data)
    {
        $validator = Validator::make(
            $data, [
            'email' => 'required',
            'isExcludedFromCampaigns'=> 'filled|boolean',
            'name'=> 'filled|string'
            ]
        );
        if ($validator->fails()) {
            return(new Response(false, $validator->errors()->getMessages()));
        }

        $body = [];
        if(isset($data['isExcludedFromCampaigns'])) {
            $body['IsExcludedFromCampaigns'] = $data['isExcludedFromCampaigns'];
        }
        if(isset($data['name'])) {
            $body['Name'] = $data['name'];
        }

        return (new Response(true, '', $body));
    }

    public static function validateCreate($data)
    {
        $validator = Validator::make(
            $data, [
            'email' => 'required|email',
            'name' => 'filled|string',
            'isExcludedFromCampaigns' => 'filled|boolean',
            ]
        );
        if ($validator->fails()) {
            return(new Response(false, $validator->errors()->getMessages()));
        }
        return (new Response(true, '', $data));
    }

}
