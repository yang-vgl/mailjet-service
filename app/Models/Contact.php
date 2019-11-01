<?php
namespace App\Models;
use Illuminate\Support\Facades\Validator;

/**
 * Only email is required
 */
class Contact
{
    const ACTION_ADDFORCE = 'addforce'; # adds the contact and resets the unsub status to false
    const ACTION_ADDNOFORCE = 'addnoforce'; # adds the contact and does not change the subscription status of the contact
    const ACTION_REMOVE = 'remove'; # removes the contact from the list
    const ACTION_UNSUB = 'unsub'; # unsubscribes a contact from the list
    const EMAIL_KEY = 'Email';
    const NAME_KEY = 'Name';
    const ACTION_KEY = 'Action';
    const PROPERTIES_KEY = 'Properties';
    protected $email;
    protected $name;
    protected $isExcludedFromCampaigns = true;
    protected $optionalProperties;
    protected $action;
    protected $error;

    public function __construct($data)
    {
        if($this->validate($data))
        {
            $this->init($data);
        }
    }

    public function validate($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'name' => 'filled|string',
            'isExcludedFromCampaigns' => 'filled|boolean',
        ]);
        if ($validator->fails()) {
            $this->error = $validator->errors()->getMessages();
            return false;
        }
        return true;
    }

    public static function validateGet($id)
    {
        $validator = Validator::make($id, [
            'id' => 'required|integer',
        ]);
        if ($validator->fails()) {
          return ['status' => false, 'msg' => $validator->errors()->getMessages()];
        }
        return ['status' => true];
    }

    public static function validateUpdate($data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'IsExcludedFromCampaigns'=> 'filled|boolean',
            'name'=> 'filled|string'
        ]);
        if ($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->getMessages()];
        }
        unset($data['id']);
        return ['status' => true, 'msg' => '', 'data' => $data];
    }

    public function init($data)
    {
        $this->setEmail($data['email']);
        if(isset($data['name'])){
            $this->setName($data['name']);
        }
        if(isset($data['isExcludedFromCampaigns'])){
            $this->setIsExcludedFromCampaigns($data['isExcludedFromCampaigns']);
        }

    }
    /**
     * Formate contact for MailJet API request
     * @return array
     */
    public function format()
    {
        $result = [
            self::EMAIL_KEY => $this->email,
        ];

        if (!is_null($this->action)) {
            $result[self::ACTION_KEY] = $this->action;
        }
        if (!is_null($this->optionalProperties)) {
            #$result[self::PROPERTIES_KEY] = $this->removeNullProperties($this->properties);
            $result[self::PROPERTIES_KEY] = $this->optionalProperties;
        }
        return $result;
    }
    /**
     * Correspond to Email in Mailjet request
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set contact email
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Correspond to Name in MailJet request
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set contact name
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getIsExcludedFromCampaigns()
    {
        return $this->isExcludedFromCampaigns;
    }
    /**
     * Set contact name
     * @param string $name
     * @return Contact
     */
    public function setIsExcludedFromCampaigns($bool)
    {
        $this->optionalProperties[self::IS_EXCLUDED_FROM_CAMPAIGNS_KEY] = $bool;
        return $this;
    }
    /**
     * Correspond to Properties in MailJet request
     * Array ['property' => value, ...]
     */
    public function getProperties()
    {
        return $this->optionalProperties;
    }
    /**
     * Set array of Contact properties
     * @param array $properties
     * @return Contact
     */
    public function setProperties(array $properties)
    {
        $this->optionalProperties = $properties;
        return $this;
    }
    /**
     * Action to the contact for Synchronization
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * Action to the contact for Synchronization
     * @param string $action ACTION_*
     * @return Contact
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    /**
     * Clean null properties to avoid conflict with API
     * @param  array  $properties
     * @return array
     */
    protected function removeNullProperties(array $properties)
    {
        return array_filter($this->optionalProperties);
    }

}
