<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Product;
use backend\models\Cat;

/**
 * ProductSearch represents the model behind the search form of `backend\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'retail', 'cat_id', 'sale', 'status', 'ord', 'home', 'hot', 'hits', 'active','best'], 'integer'],
            [['name', 'url', 'path', 'code', 'brief', 'description', 'seo_title', 'seo_keyword', 'seo_desc'], 'safe'],
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
        $query = Product::find()
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

        if (!empty($this->cat_id)) {
            $arr_ids = [$this->cat_id];
            $cat_model = Cat::findOne($this->cat_id);
            $subcat = $cat_model->getSubCat();
            if (!empty($subcat)) {
              foreach ($subcat as $item) {
                $arr_ids[] = $item->id;
                $subcat_1 = $item->getSubCat();
                foreach ($subcat_1 as $row) {
                  $arr_ids[] = $row->id;
                }
              }
            }
            $query->leftJoin('cat_product', '`cat_product`.`product_id` = `product`.`id`');
            $query->andFilterWhere(['or', ['cat_product.cat_id' => $arr_ids], ['product.category_id' => $arr_ids]]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'brand_id' => $this->brand_id,
            'retail' => $this->retail,
            'sale' => $this->sale,
            'status' => $this->status,
            '{{product}}.ord' => $this->ord,
            'home' => $this->home,
            'hot' => $this->hot,
            'hits' => $this->hits,
            'best' => $this->best,
            '{{product}}.active' => $this->active,
        ]);

        $query->andFilterWhere(['like', '{{product}}.name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', '{{product}}.path', $this->path])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'brief', $this->brief])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword])
            ->andFilterWhere(['like', 'seo_desc', $this->seo_desc]);

        return $dataProvider;
    }
}
