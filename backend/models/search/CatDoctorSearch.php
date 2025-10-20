<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CatDoctor;

/**
 * CatDoctorSearch represents the model behind the search form of `backend\models\CatDoctor`.
 */
class CatDoctorSearch extends CatDoctor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ord', 'home', 'active', 'parent','hot'], 'integer'],
            [['name', 'url', 'path', 'description', 'seo_title', 'seo_desc', 'seo_keyword','hot'], 'safe'],
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
        $query = CatDoctor::find()->select(['*', 'REPLACE(path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => Yii::$app->params['record_per_page']],
            'sort' => ['defaultOrder' => ['ord'=>SORT_ASC,'id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ord' => $this->ord,
            'home' => $this->home,
            'hot' => $this->hot,
            'active' => $this->active,
            'parent' => $this->parent,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_desc', $this->seo_desc])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword]);

        return $dataProvider;
    }
}
