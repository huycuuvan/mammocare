<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "buyer".
 *
 * @property int $id
 * @property string $fullname
 * @property string $mobile
 * @property string $email
 * @property string $content
 * @property string $address
 * @property int $type_id
 * @property string $bill_json
 * @property string $ordered_time
 */
class Buyer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buyer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'mobile', 'address', 'ordered_time'], 'required'],
            [['content', 'bill_json', 'total_price'], 'string'],
            [['type_id'], 'integer'],
            [['ordered_time'], 'safe'],
            [['fullname', 'email', 'address'], 'string', 'max' => 200],
            [['mobile'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'fullname' => 'Họ tên',
            'mobile' => 'Điện thoại',
            'email' => 'Email',
            'content' => 'Yêu cầu',
            'address' => 'Địa chỉ',
            'ordered_time' => 'Thời gian',
            'bill_json' => 'Đơn hàng',
            'type_id' => 'Thanh toán'
        ];
    }

    public static function countBill()
    {
        return Yii::$app->db->createCommand('SELECT COUNT(*) FROM buyer')->queryScalar();
    }
}
