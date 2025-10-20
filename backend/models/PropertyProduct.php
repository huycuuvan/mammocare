<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cat_product".
 *
 * @property int $id
 */

class PropertyProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['property_id', 'product_id', 'property_value_id'], 'required'],
            [['property_id', 'product_id', 'property_value_id', 'attachment_id', 'property_price', 'active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'property_id' => 'Property ID',
            'product_id' => 'Product ID',
            'attachment_id' => 'Attachment ID',
            'property_price' => 'Property price',
            'active' => 'Active'
        ];
    }

    public static function getPropertyByProduct($product_id)
    {
        return self::find()
            ->where(['product_id' => $product_id])
            ->joinWith(['property'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
    }

    public static function getPropertyDllByProductId($id)
    {
        return ArrayHelper::map(self::getPropertyByProduct($id), 'id', 'property_value_id');
    }

    public function getAttachment()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'attachment_id']);
    }

    public function getPropertyValue()
    {
        return $this->hasOne(PropertyValue::className(), ['id' => 'property_value_id']);
    }

    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

}
