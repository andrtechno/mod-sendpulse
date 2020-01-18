<?php

namespace panix\mod\sendpulse\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use panix\mod\sendpulse\models\SettingsForm;

class SettingsController extends AdminController
{

    public $icon = 'settings';

    public function actionIndex()
    {

        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->breadcrumbs = [
            [
                'label' => $this->module->info['label'],
                'url' => $this->module->info['url'],
            ],
            $this->pageName
        ];
        $model = new SettingsForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
