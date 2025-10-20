<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cat_product".
 *
 * @property int $id
 * @property int $property_string
 * @property int $product_id
 */
class PropertyPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_string', 'product_id'], 'required'],
            [['property_string', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_string' => 'Cat ID',
            'product_id' => 'Product ID',
        ];
    }
    public static function getPropertyPrice($product_id)
    {
        $model = PropertyPrice::find()
            ->andWhere('product_id ='.$product_id)->all();
        return $model;
    }
}
