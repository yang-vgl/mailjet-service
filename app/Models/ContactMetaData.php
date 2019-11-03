<?php
namespace App\Models;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * https://dev.mailjet.com/email-api/v3/contactmetadata/
 * Manage Contact Additional Atributes
 */
class ContactMetaData
{
    const DATATYPE = ['str', 'int', 'float','bool','datetime'];
    protected $name;
    protected $datatype;

    public function __construct($data)
    {

    }

    public static function validateCreate($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'dataType' => [
                'required',
                Rule::in(self::DATATYPE),
            ]
        ]);
        if ($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->getMessages()];
        }
        return [true];
    }

    public static function validateUpdate($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'data.*.Name' => 'required',
            'data.*.Value' => 'required',
        ]);
        if ($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->getMessages()];
        }
        return ['status' => true];
    }

}
