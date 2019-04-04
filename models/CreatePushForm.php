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

    public function rules()
    {
        return [
            [['title', 'body'], "required"],
            [['title'], 'string', 'max' => 50],
            [['body'], 'string', 'max' => 125],
            [['link'], 'trim'],
            [['link'], 'string'],
            [['send_date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            //[['website_id','push_ttl'], 'integer'],
        ];
    }

}