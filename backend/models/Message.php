<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $content
 * @property int $type_id
 * @property int $active
 */
class Message extends \yii\db\ActiveRecord
{
    const RESET_PASSWORD = 1;
    const SHOPCART = 2;
    const ACTIVE_ACCOUNT = 3;
    const REQUEST_PASS = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
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
            [['name', 'content', 'type_id'], 'required'],
            [['created_at'], 'safe'],
            [['content'], 'string'],
            [['type_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'created_at' => 'Ngày tạo',
            'name' => 'Tiêu đề',
            'content' => 'Nội dung',
            'type_id' => 'Kiểu',
            'active' => 'Kích hoạt',
        ];
    }

    //receive types of category array
    public static function getType()
    {
        return [
            self::RESET_PASSWORD => 'Lấy lại mật khẩu',
            self::SHOPCART => 'Thông báo đặt hàng',
            self::ACTIVE_ACCOUNT => 'Kích hoạt tài khoản',
            self::REQUEST_PASS => 'Yêu cầu mật khẩu',
        ];
    }

    public static function getMessage($type, $options = [])
    {
        $model = Message::findOne(['type_id' => $type, 'active' => 1]);
        if (!empty($model)) {
            $content = $model->content;
            $title = $model->name;
            if (!empty($options)) {
                foreach ($options as $key => $val) {
                    $content = str_replace($key, $val, $content);
                    $title = str_replace($key, $val, $title);
                }
            }
            return [
                'title' => $title,
                'content' => $content,
            ];
        }

        return null;
    }
}
