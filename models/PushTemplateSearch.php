<?php

namespace panix\mod\pages\models;

use Yii;
use yii\base\Model;
use panix\engine\data\ActiveDataProvider;
use panix\mod\sendpulse\models\PushTemplate;
/**
 * PushTemplateSearch represents the model behind the search form about `panix\sendpulse\models\PushTemplate`.
 */
class PushTemplateSearch extends PushTemplate {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id','views'], 'integer'],
            [['name','slug','date_create'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = PushTemplate::find();


        $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort'=> self::getSort(),
                ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', PagesTranslate::tableName().'.name', $this->name]);
        $query->andFilterWhere(['like', 'DATE(date_create)', $this->date_create]);
        $query->andFilterWhere(['like', 'DATE(date_update)', $this->date_update]);
        $query->andFilterWhere(['like', 'views', $this->views]);

        return $dataProvider;
    }
    public static function getSort() {
        $sort = new \yii\data\Sort([
            'attributes' => [
                'date_create',
                'date_update',
                'views',
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                ],
            ],
        ]);
        return $sort;
    }
}
