<?php

namespace panix\mod\sendpulse\models;

use panix\engine\SettingsModel;

class SettingsForm extends SettingsModel
{

    public static $category = 'sendpulse';
    protected $module = 'sendpulse';
    public $api_id;
    public $api_secret;
    public $website_id;
    public $push_ttl = 20;

    public function rules()
    {
        return [
            [['api_id', 'api_secret', 'website_id','push_ttl'], "required"],
            [['api_id', 'api_secret'], 'string', 'max' => 32],
            [['website_id','push_ttl'], 'integer'],
        ];
    }

}