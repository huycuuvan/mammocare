<?php

namespace backend\models;

use Yii;
use backend\models\Product;

/**
 * This is the model class for table "booking".
 *
 * @property int $id
 * @property string $date_from
 * @property string $date_to
 * @property int $adult
 * @property int $child
 * @property int $product_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $note
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'booking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to', 'adult', 'child','room_number'], 'required'],
            [['date_from', 'date_to', 'product_id', 'name', 'address', 'phone', 'email'], 'safe'],
            [['adult', 'child', 'product_id'], 'integer'],
            [['note'], 'string'],
            [['name', 'address', 'phone'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            ['email', 'email'],

            [['name','address','phone'], 'required', 'on' => 'checkroom']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_from' => 'Ngày đến',
            'date_to' => 'Ngày đi',
            'adult' => 'Người lớn',
            'child' => 'Trẻ em',
            'product_id' => 'Phòng',
            'name' => 'Họ tên',
            'address' => 'Địa chỉ',
            'phone' => 'Điện thoại',
            'email' => 'Email',
            'note' => 'Ghi chú',
            'room_number'=>'Số lượng'
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
