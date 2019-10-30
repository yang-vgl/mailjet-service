<?php

namespace App\Templates;

use Illuminate\Support\Facades\Validator;

class Confirmation
{
    protected static $id = 1064860;

    protected $content = null;

    protected $toEmail = null;

    protected $toName = null;

    protected $link = null;

    public function __construct($data=[])
    {
        $this->validate($data);
    }

    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'toEmail' => 'required|email',
            'link' => 'required|url',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
        $this->toEmail = $data['toEmail'];
        $this->link = $data['link'];
        $this->toName = isset($data['toName']) ? $data['toName'] : 'Cruiser';
    }

    public function setToEmail($toEmail) {
        $this->toEmail = $toEmail;
    }

    public function getToEmail() {
        return $this->toEmail;
    }

    public function setLink($link) {
        $this->$link = $link;
    }

    public function getLink() {
        return $this->link;
    }

    public function setToName($toName) {
        $this->toName = $toName;
    }

    public function getToName($toName) {
        return $this->toName;
    }

}
