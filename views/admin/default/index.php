<?php

echo yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        [
            'attribute' => 'website_id',
            'format' => 'html',
            'value' => function ($data) {
                return \panix\engine\Html::a($data['website_id'], ['/admin/sendpulse/push/subscriptions', 'id' => $data['website_id']]);
            },
        ],
        [
            'attribute' => 'id',
            'format' => 'html',
            'value' => function ($data) {
                return \panix\engine\Html::a($data['id'], ['/admin/sendpulse/push/view', 'id' => $data['id']]);
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