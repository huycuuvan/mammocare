<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cat_product".
 *
 * @property int $id
 * @property int $cat_id
 * @property int $product_id
 */
class CatProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_id', 'product_id'], 'required'],
            [['cat_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'product_id' => 'Product ID',
        ];
    }
}
