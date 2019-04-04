<?php

namespace panix\mod\sendpulse\controllers\admin;

use Yii;
use panix\engine\controllers\AdminController;
use yii\data\ArrayDataProvider;

class PushController extends AdminController
{
    public function actionIndex()
    {


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