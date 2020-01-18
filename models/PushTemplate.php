<?php

namespace panix\mod\sendpulse\models;

use Yii;
use panix\engine\db\ActiveRecord;
use panix\engine\behaviors\TranslateBehavior;
use panix\mod\pages\models\PagesTranslate;
use panix\mod\pages\models\PagesQuery;

/**
 * This is the model class for table "sendpulse".
 *
 * @property integer $id
 * @property string $name
 */
class PushTemplate extends ActiveRecord {

    const route = '/admin/pages/default';
    const MODULE_ID = 'sendpulse';

    //public $disallow_delete = [32, 33];
    //public $disallow_update = [32];
    //public $disallow_switch = [32];

    public static function find() {
        return new PagesQuery(get_called_class());
    }

    public function getGridColumns() {
        return [
            'id',
            'name',
            [
                'attribute' => 'views',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'text',
                'format' => 'html'
            ],
            [
                'attribute' => 'date_create',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new PagesSearch(),
                    'attribute' => 'date_create',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->date_create, 'php:d D Y H:i:s');
                }
            ],
            [
                'attribute' => 'date_update',
                'format' => 'raw',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => new PagesSearch(),
                    'attribute' => 'date_update',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->date_update, 'php:d D Y H:i:s');
                }
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%push_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'text', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['name', 'slug'], 'trim'],
            ['slug', '\panix\engine\validators\UrlValidator','attributeCompare'=>'name'],
            ['slug', 'match',
                'pattern' => '/^([a-z0-9-])+$/i',
                'message' => Yii::t('app/default','PATTERN_URL')
            ],
            [['date_update', 'date_create'], 'safe'],
                //[['date_update'], 'date', 'format' => 'php:U']
                /// [['date_update'], 'date','format'=>'php:U', 'timestampAttribute' => 'date_update','skipOnEmpty'=>  true],
//[['date_update','date_create'], 'filter','filter'=>'strtotime'],
        ];
    }

    public function renderText() {
        if (Yii::$app->user->can('admin')) {
            \panix\ext\tinymce\TinyMceInline::widget();
        }
        return (Yii::$app->user->can('admin')) ? $this->isText('text') : $this->pageBreak('text');
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTranslations() {
        return $this->hasMany(PagesTranslate::class, ['object_id' => 'id']);
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge([
                    'translate' => [
                        'class' => TranslateBehavior::class,
                        'translationAttributes' => [
                            'name',
                            'text'
                        ]
                    ],
                    'commentBehavior' => [
                        'class' => \panix\mod\comments\components\CommentBehavior::class,
                        'owner_title' => 'name',
                    ],
                        ], parent::behaviors());
    }

}
