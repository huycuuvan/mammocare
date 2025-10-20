<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Brand;

/**
 * BrandSearch represents the model behind the search form of `backend\models\Brand`.
 */
class BrandSearch extends Brand
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ord', 'active', 'home'], 'integer'],
            [['name', 'path', 'url', 'description', 'seo_title', 'seo_desc', 'seo_keyword'], 'safe'],
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
        $query = Brand::find()->select(['{{brand}}.*', 'REPLACE({{brand}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb'])
        ->joinWith('language')
        ->where('{{language}}.code = "'.Yii::$app->language.'"');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => Yii::$app->params['record_per_page']],
            'sort' => ['defaultOrder' => ['ord' => SORT_ASC, 'id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{brand}}.id' => $this->id,
            '{{brand}}.ord' => $this->ord,
            '{{brand}}.active' => $this->active,
            'home' => $this->home,
        ]);

        $query->andFilterWhere(['like', '{{brand}}.name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_desc', $this->seo_desc])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword]);

        return $dataProvider;
    }
}
