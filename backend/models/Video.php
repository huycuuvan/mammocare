<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $path
 * @property int $ord
 * @property int $active
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['ord', 'active', 'home', 'lang_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên video',
            'code' => 'Mã video Youtube',
            'home' => 'Trang chủ',
            'ord' => 'Thứ tự',
            'active' => 'Hiển thị',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
    public static function getVideo()
    {
        return Video::find()->where(['active' => 1])->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->all();
    }

    public static function getHomeVideo()
    {
        return Video::find() ->joinWith(['language'])->where(['{{video}}.active' => 1, 'home' => 1, '{{language}}.code' => Yii::$app->language])->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->all();
    }
}
