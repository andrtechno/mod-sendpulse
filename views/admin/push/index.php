sss<?php


$task = array(
    'title' => 'Hello!',
    'body' => 'This is my first push message',
    'website_id' => 32245,
);

// This is optional
$additionalParams = array(
    'link' => 'http://yoursite.com',
    /*'buttons' => [
        ['text' => 'asad', 'link' => 'sss'],
        ['text' => 'asad1111', 'link' => 'sss11']
    ],*/
    //'icon'=>['name'=>'','data'=>''],
    'filter_browsers' => 'Chrome,Safari',
    'filter_lang' => 'ru',
    //   'filter' => '{"variable_name":"some","operator":"or","conditions":[{"condition":"likewith","value":"a"},{"condition":"notequal","value":"b"}]}',
);


//print_r(Yii::$app->sendpulse->push($task,$additionalParams));

echo yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
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
        ],
        [
            'attribute' => 'title',
            'format' => 'html',
            'value' => function ($data) {
                return '<strong>' . $data['title'] . '</strong><br/>' . $data['body'];
            },
        ],
        [
            'attribute' => 'send_date',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($data) {
                return \panix\engine\CMS::date($data['send_date']);
            },
        ],
        [
            'attribute' => 'status',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($data) {
                return \panix\mod\sendpulse\components\SendPulseHelper::pushStatus($data['status']);
            },
        ],
    ]
]);