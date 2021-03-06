<?php

namespace panix\mod\sendpulse;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

/**
 * Class Module
 *
 * Register js you layout
 * <code>
 * $this->registerJsFile('//cdn.sendpulse.com/js/push/XXXXXX.js',[
 *      'position' => \yii\web\View::POS_HEAD,
 *      'charset' => Yii::$app->charset,
 *      'async' => 'async'
 * ])
 * </code>
 * @package panix\mod\sendpulse
 */
class Module extends WebModule implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $config = $app->settings->get('sendpulse');
        if ($config) {
            if ($config->api_id && $config->api_secret)
                $app->setComponents([
                    'sendpulse' => ['class' => 'panix\mod\sendpulse\components\SendPulse'],
                ]);
        }
    }

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('sendpulse/default', 'MODULE_NAME'),
                        'url' => ['/admin/sendpulse/default'],
                        'icon' => $this->icon,
                    ],
                ],
            ],
        ];
    }

    public function getInfo()
    {
        return [
            'label' => Yii::t('sendpulse/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('sendpulse/default', 'MODULE_DESC'),
            'url' => ['/admin/sendpulse/default'],
        ];
    }

}
