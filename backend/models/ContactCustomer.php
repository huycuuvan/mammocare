<?php

namespace backend\models;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

use Yii;

/**
 * This is the model class for table "contact_customer".
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property string $title
 * @property string $content
 * @property string $created_at
 */
class ContactCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_customer';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression("NOW()"),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'title'], 'required'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['name', 'email', 'title'], 'string', 'max' => 255],
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
            'name' => 'Họ tên',
            'mobile' => 'Điện thoại',
            'email' => 'Email',
            'title' => 'Tiêu đề',
            'content' => 'Nội dung',
            'created_at' => 'Ngày tạo',
        ];
    }

    public static function getLatestFive()
    {
        return ContactCustomer::find()
        ->orderBy(['id' => SORT_DESC])
        ->limit(5)
        ->all();
    }
}
