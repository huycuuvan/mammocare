<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cat_product".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $product_id
 */
class CatBrand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_brand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'product_id'], 'required'],
            [['brand_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Cat ID',
            'product_id' => 'Product ID',
        ];
    }
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
}
