<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Booking;

/**
 * BookingSearch represents the model behind the search form of `backend\models\Booking`.
 */
class BookingSearch extends Booking
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'adult', 'child', 'product_id'], 'integer'],
            [['date_from', 'date_to','name','address','phone'], 'safe'],
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
        $query = Booking::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $ngayden=$this->date_from;
        $ngayden1=explode('/',$this->date_from);
        if(empty($ngayden1)){
            $ngayden = preg_replace('/^(\d{1,2})-(\d{1,2})-(\d{2,4})$/',"$3-$2-$1",$ngayden); //for day-month-year
        }
        else{
            if(count($ngayden1)>2)
                $ngayden=$ngayden1[2].'-'.$ngayden1[1].'-'.$ngayden1[0];
        }
        if($this->date_from!='')
            $query->andFilterWhere(['like', 'date_from', "$ngayden"]);


        $ngaydi=$this->date_to;
        $ngaydi1=explode('/',$this->date_to);
        if(empty($ngaydi1)){
            $ngaydi = preg_replace('/^(\d{1,2})-(\d{1,2})-(\d{2,4})$/',"$3-$2-$1",$ngayden); //for day-month-year
        }
        else{
            if(count($ngaydi1)>2)
                $ngaydi=$ngaydi1[2].'-'.$ngaydi1[1].'-'.$ngaydi1[0];
        }
        if($this->date_to!='')
            $query->andFilterWhere(['like', 'date_to', "$ngaydi"]);
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'adult' => $this->adult,
            'child' => $this->child,
            'product_id' => $this->product_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
