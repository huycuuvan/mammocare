<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Seo;

/**
 * SeoSearch represents the model behind the search form of `backend\models\Seo`.
 */
class SeoSearch extends Seo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'integer'],
            [['site_title', 'site_keyword', 'site_desc'], 'safe'],
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
        $query = Seo::find()
        ->select(['{{seo}}.*', 'REPLACE({{seo}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb'])
        ->joinWith('language')
        ->where('{{language}}.code = "'.Yii::$app->language.'"');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{seo}}.id' => $this->id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'site_title', $this->site_title])
            ->andFilterWhere(['like', 'site_keyword', $this->site_keyword])
            ->andFilterWhere(['like', 'site_desc', $this->site_desc]);

        return $dataProvider;
    }
}
