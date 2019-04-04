<?php

namespace panix\mod\sendpulse\models;

use panix\engine\base\Model;


class CreatePushForm extends Model
{

    protected $category = 'sendpulse';
    protected $module = 'sendpulse';
    public $title;
    public $body;
    public $send_date;
    public $link;
    public $button1_text;
    public $button1_link;
    public $button2_text;
    public $button2_link;

    public function rules()
    {
        return [
            [['title', 'body'], "required"],
            [['title', 'button1_text', 'button2_text'], 'string', 'max' => 50],
            [['body'], 'string', 'max' => 125],
            [['link'], 'trim'],
            [['button1_link', 'button2_link'], 'url'],
            [['link', 'button1_link', 'button2_link'], 'string'],
            [['send_date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            //[['website_id','push_ttl'], 'integer'],
        ];
    }

}