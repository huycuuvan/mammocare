<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tab;
use yii\db\Expression;

/**
 * TabSearch represents the model behind the search form of `backend\models\Tab`.
 */
class TabSearch extends Tab
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'code'], 'safe'],
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
        $query = Tab::find()
        ->joinWith('language')
        ->where('{{language}}.code = "'.Yii::$app->language.'"');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => Yii::$app->params['record_per_page']],
            'sort' => ['defaultOrder' => ['ord' => SORT_ASC, 'id' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['ord'] = [
             'asc' => [new Expression('{{tab}}.ord IS NULL ASC, {{tab}}.ord ASC')],
             'desc' => [new Expression('{{tab}}.ord IS NULL ASC, {{tab}}.ord DESC')],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            '{{tab}}.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', '{{tab}}.name', $this->name])
            ->andFilterWhere(['like', '{{tab}}.code', $this->code]);

        return $dataProvider;
    }
}
