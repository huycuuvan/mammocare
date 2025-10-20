<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\News;

/**
 * NewsSearch represents the model behind the search form of `backend\models\News`.
 */
class NewsSearch extends News
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'hot', 'home', 'active', 'hits', 'cat_id'], 'integer'],
            [['title', 'path', 'url', 'brief', 'content', 'created_at', 'updated_at', 'tags', 'seo_title', 'seo_keyword', 'seo_desc'], 'safe'],
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
        $query = News::find()
        ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb'])
        ->joinWith('language')
        ->where('{{language}}.code = "'.Yii::$app->language.'"');

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => Yii::$app->params['record_per_page']],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{news}}.id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'hot' => $this->hot,
            'home' => $this->home,
            '{{news}}.active' => $this->active,
            'hits' => $this->hits,
            'cat_id' => $this->cat_id
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', '{{news}}.path', $this->path])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'brief', $this->brief])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword])
            ->andFilterWhere(['like', 'seo_desc', $this->seo_desc]);

        return $dataProvider;
    }
}
