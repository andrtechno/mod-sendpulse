<?php

namespace panix\mod\sendpulse\controllers\admin;

use panix\engine\Html;
use panix\mod\sendpulse\models\CreatePushForm;
use Yii;
use yii\helpers\Json;
use panix\engine\controllers\AdminController;
use yii\data\ArrayDataProvider;

class PushController extends AdminController
{
    public function actionIndex()
    {
        $this->pageName = Yii::t('sendpulse/default', 'MODULE_NAME');
        $this->breadcrumbs[] = $this->pageName;
        $this->buttons = [
            [
                'label' => Yii::t('sendpulse/default', 'SEND_PUSH'),
                'url' => ['/admin/sendpulse/push/create'],
                'icon' => 'icon-notification',
                'options' => ['class' => 'btn btn-success']
            ]
        ];

        $pushListCampaigns = [];
        foreach (Yii::$app->sendpulse->api->pushListCampaigns() as $data) {
            $pushListCampaigns[] = [
                'id' => $data->id,
                'title' => $data->title,
                'body' => $data->body,
                'website_id' => $data->website_id,
                'send_date' => $data->send_date,
                'status' => $data->status,
            ];

        }

        $provider = new ArrayDataProvider([
            'allModels' => $pushListCampaigns,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'title'],
            ],
        ]);


        return $this->render('index', ['provider' => $provider]);
    }


    public function actionView($id)
    {


        $this->pageName = Yii::t('sendpulse/default', 'PUSH');
        $this->breadcrumbs[] = [
            'label'=>Yii::t('sendpulse/default', 'MODULE_NAME'),
            'url'=>['/admin/sendpulse/push']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $result = Yii::$app->sendpulse->api->getPushCampaignStat($id);
        return $this->render('view', ['result' => $result]);
    }


    public function actionCreate()
    {

        $this->pageName = Yii::t('sendpulse/default', 'PUSH');
        $this->breadcrumbs[] = [
            'label'=>Yii::t('sendpulse/default', 'MODULE_NAME'),
            'url'=>['/admin/sendpulse/push']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $model = new CreatePushForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $file = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'logo.png';

            $task = [
                'title' => $model->title,
                'body' => $model->body,
            ];

            $additionalParams = [];
            if (!empty($model->link)) {
                $additionalParams['link'] = $model->link;
            }
            if (!empty($model->send_date)) {
                $additionalParams['send_date'] = $model->send_date;
            }
            $buttons = [];
            if (!empty($model->button1_text) && !empty($model->button1_link)) {
                $buttons[] = ['text' => $model->button1_text, 'link' => $model->button1_link];
            }
            if (!empty($model->button2_text) && !empty($model->button2_link)) {
                $buttons[] = ['text' => $model->button2_text, 'link' => $model->button2_link];
            }
            if ($buttons)
                $additionalParams['buttons'] = Json::encode($buttons);
            $additionalParams['icon'] = Json::encode(['name' => 'icon.png', 'data' => base64_encode(file_get_contents($file))]);


            $response = Yii::$app->sendpulse->push($task, $additionalParams);
            if (isset($response->is_error)) {
                Yii::$app->session->setFlash('error', Yii::t('sendpulse/error', $response->error_code));
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', 'SUCCESS_SEND'));
            }
            return Yii::$app->response->redirect(['/admin/sendpulse/push/create']);

        }
        return $this->render('create', ['model' => $model]);
    }


    public function actionSubscriptions($id)
    {
        //@todo add deative/active
        //pushSetSubscriptionState($subscriptionID, $stateValue);
        $this->pageName = Yii::t('sendpulse/default', 'SUBSCRIPTIONS');
        $this->breadcrumbs[] = [
            'label'=>Yii::t('sendpulse/default', 'MODULE_NAME'),
            'url'=>['/admin/sendpulse/push']
        ];
        $this->breadcrumbs[] = $this->pageName;

        $result = [];
        foreach (Yii::$app->sendpulse->api->pushListWebsiteSubscriptions($id) as $data) {
            $result[] = [
                'id' => $data->id,
                'browser' => $data->browser,
                'lang' => $data->lang,
                'os' => $data->os,
                'country_code' => $data->country_code,
                'city' => $data->city,
                // 'variables' => $data->variables, //arrary
                'subscription_date' => $data->subscription_date,
                'status' => $data->status,
            ];
        }

        $provider = new ArrayDataProvider([
            'allModels' => $result,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'title'],
            ],
        ]);
        return $this->render('subscriptions', ['provider' => $provider]);
    }


    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('app', 'SETTINGS'),
                'url' => array('/admin/sendpulse/settings'),
                'icon' => 'icon-settings',
            ],
        ];
    }
}