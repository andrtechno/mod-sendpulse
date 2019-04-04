<?php

namespace panix\mod\sendpulse\models;

use panix\engine\SettingsModel;

class SettingsForm extends SettingsModel
{

    protected $category = 'sendpulse';
    protected $module = 'sendpulse';
    public $api_id;
    public $api_secret;
    public $website_id;

    public function rules()
    {
        return [
            [['api_id', 'api_secret', 'website_id'], "required"],
            [['api_id', 'api_secret'], 'string', 'max' => 32],
            ['website_id', 'integer'],
        ];
    }

}