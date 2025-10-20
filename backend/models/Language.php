<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $path
 * @property int $ord
 * @property int $defa
 * @property int $active
 */
class Language extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb;

    use HasImgTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'iso_code'], 'required'],
            [['ord', 'defa', 'active'], 'integer'],
            [['code', 'iso_code'], 'string', 'max' => 20],
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
            'code' => 'Mã ngôn ngữ',
            'name' => 'Ngôn ngữ',
            'iso_code' => 'Mã ISO',
            'path' => 'Cờ',
            'ord' => 'Thứ tự',
            'defa' => 'Mặc định',
            'active' => 'Hiển thị',
            'thumb' => 'Ảnh'
        ];
    }

    public static function getLanguage()
    {
        return Language::find()->where('active=1')->all();
    }

    public static function getLanguageDDL($lang_id = null)
    {
        if (is_int($lang_id))
            return ArrayHelper::map(Language::find()->where('active=1 AND id = '.$lang_id)->all(), 'id', 'name');
        elseif (is_string($lang_id))
            return ArrayHelper::map(Language::find()->where('active=1 AND code = "'.$lang_id.'"')->all(), 'id', 'name');
        else
            return ArrayHelper::map(Language::find()->where('active=1')->all(), 'id', 'name');
    }
}
