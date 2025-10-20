<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Partner;

/**
 * PartnerSearch represents the model behind the search form of `backend\models\Partner`.
 */
class PartnerSearch extends Partner
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'position', 'ord', 'active','home'], 'integer'],
            [['name', 'path', 'content', 'url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Partner::find()
        ->select(['{{partner}}.*', 'REPLACE({{partner}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb'])
        ->joinWith('language')
        ->where('{{language}}.code = "'.Yii::$app->language.'"');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => Yii::$app->params['record_per_page']],
            'sort' => ['defaultOrder' => ['position' => SORT_ASC, 'ord' => SORT_ASC, 'id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{partner}}.id' => $this->id,
            'position' => $this->position,
            '{{partner}}.ord' => $this->ord,
            '{{partner}}.home' => $this->home,
            '{{partner}}.active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
