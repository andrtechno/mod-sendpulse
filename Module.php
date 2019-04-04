<?php

namespace panix\mod\sendpulse;

use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface {

    public function bootstrap($app)
    {
        $app->urlManager->addRules(
            [
                'sendpulse' => 'sendpulse/default/index',
            ],
            false
        );
    }
}
