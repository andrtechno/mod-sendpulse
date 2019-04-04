<?php

namespace panix\mod\sendpulse\controllers\admin;

use panix\mod\sendpulse\models\CreatePushForm;
use Yii;
use yii\helpers\Json;
use panix\engine\controllers\AdminController;
use yii\data\ArrayDataProvider;

class PushController extends AdminController
{
    public function actionIndex()
    {

        $this->buttons = [
            [
                'label' => 'Отправить Push',
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
        $result = Yii::$app->sendpulse->api->getPushCampaignStat($id);
        return $this->render('view', ['result' => $result]);
    }


    public function actionCreate()
    {
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
            /* $additionalParams['buttons'] = Json::encode([
                 ['text' => 'asad', 'link' => 'sss'],
                 ['text' => 'asad1111', 'link' => 'sss11']
             ]);*/
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
}