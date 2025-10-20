<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PropertyValue;

/**
 * PropertyValueSearch represents the model behind the search form of `backend\models\PropertyValue`.
 */
class PropertyValueSearch extends PropertyValue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ord', 'property_id'], 'integer'],
            [['name','code'], 'safe'],
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
    public function search($params,$property)
    {
        $query = PropertyValue::find()->where('property_id='.$property);

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
            'id' => $this->id,
            'ord' => $this->ord,
            'property_id' => $this->property_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'code', $this->code]);
//        $query->andFilterWhere(['like', 'p_from', $this->p_from]);
//        $query->andFilterWhere(['like', 'p_to', $this->p_to]);

        return $dataProvider;
    }

}
