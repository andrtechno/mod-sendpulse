<?php
echo yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id',
       /* [
            'attribute' => 'website_id',
            'format' => 'html',
            'value' => function ($data) {
                return \panix\engine\Html::a($data['website_id'],['/admin/sendpulse/push/subscriptions','id'=>$data['website_id']]);
            },
        ],
        [
            'attribute' => 'id',
            'format' => 'html',
            'value' => function ($data) {
                return \panix\engine\Html::a($data['id'],['/admin/sendpulse/push/view','id'=>$data['id']]);
            },
        ],*/
        [
            'attribute' => 'country_code',
            'format' => 'html',
            'value' => function ($data) {
                return '<strong>' . $data['country_code'] . '</strong><br/>' . $data['city'];
            },
        ],
        [
            'attribute' => 'os',
            'format' => 'html',
            'value' => function ($data) {
                return '<strong>' . $data['os'] . '</strong><br/>' . $data['browser'].'<br/>' . $data['lang'];
            },
        ],
        [
            'attribute' => 'subscription_date',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($data) {
                return \panix\engine\CMS::date($data['subscription_date']);
            },
        ],
        [
            'attribute' => 'status',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($data) {
                return \panix\mod\sendpulse\components\SendPulseHelper::pushSubscriptionsStatus($data['status']);
            },
        ],
    ]
]);