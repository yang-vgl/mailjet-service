<?php
namespace App\Models;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactList
{

    const ACTIONS = [
        'addforce',   # adds the contact and resets the unsub status to false
        'addnoforce', # adds the contact and does not change the subscription status of the contact
        'remove',     # removes the contact from the list
        'unsub'       # unsubscribes a contact from the list
    ];

    public static function validateCreate($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return ['status' => false,  'msg' => $validator->errors()->getMessages()];
        }
        return ['status' => true, 'data' => $data];
    }

    public static function validateUpdate($data)
    {
        $validator = Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return ['status' => false,  'msg' => $validator->errors()->getMessages()];
        }
        return ['status' => true, 'data' => $data];
    }

    public static function validateContactsManagement($data)
    {
        $validator = Validator::make($data, [
            'contacts' => 'required|array',
            'contacts.*' => 'required|email',
            'contactLists.*.action' =>  [
                'required',
                Rule::in(self::ACTIONS),
            ],
            'contactLists.*.listId' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return ['status' => false,  'msg' => $validator->errors()->getMessages()];
        }
        $body = [];
        foreach($data['contacts'] as $val){
            $body['Contacts'][]['Email'] = $val;
        }
        foreach($data['contactLists'] as $val)
        {
            $body['ContactsLists'][] = [
                'Action' => $val['action'],
                'ListID' => $val['listId'],
            ];
        }
        return ['status' => true, 'data' => $body];
    }



}
