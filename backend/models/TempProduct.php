<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "temp_product".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $price
 * @property int $cat_id
 * @property int $type_id
 */
class TempProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'temp_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['price', 'cat_id', 'type_id'], 'integer'],
            [['name', 'path'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên sản phẩm',
            'path' => 'Ảnh',
            'price' => 'Giá',
            'cat_id' => 'Danh mục',
            'type_id' => 'Kiểu loại'
        ];
    }
}
