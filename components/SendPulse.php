<?php

namespace panix\mod\sendpulse\components;

use Yii;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;

class SendPulse extends \yii\base\Component
{

    public $api;
    public $config;

    public function __construct($config = [])
    {
        $this->config = Yii::$app->settings->get('sendpulse');
        $this->api = new ApiClient($this->config->api_id, $this->config->api_secret, new FileStorage(Yii::getAlias('@runtime/')));
        parent::__construct($config);
    }

    public function push($task, $additionalParams)
    {
        if (!isset($task['website_id'])) {
             $task['website_id'] = $this->config->website_id;
        }
        if (!isset($task['stretch_time']))
            $task['stretch_time'] = 0;

        if (!isset($task['ttl']))
            $task['ttl'] = $this->config->push_ttl;

        if (!isset($additionalParams['link']))
            $additionalParams['link'] = Yii::$app->request->hostInfo;

        return $this->api->createPushTask($task, $additionalParams);
    }

    protected function getPushTaskOptions(){

    }
}