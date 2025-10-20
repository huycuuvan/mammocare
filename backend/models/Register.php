<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "register".
 *
 * @property int $id
 * @property string $fullname
 * @property string $mobile
 * @property string $email
 * @property int $tour_id
 * @property string $created_at
 * @property string $viewed_at
 * @property int $viewed
 * @property int $highlight
 */
class Register extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fullname', 'mobile', 'email', 'tour_id'], 'required'],
            [['tour_id', 'viewed', 'highlight'], 'integer'],
            [['created_at', 'viewed_at'], 'safe'],
            [['fullname', 'mobile', 'email'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'tour_id' => 'Tour ID',
            'created_at' => 'Created At',
            'viewed_at' => 'Viewed At',
            'viewed' => 'Viewed',
            'highlight' => 'Highlight',
        ];
    }
}
