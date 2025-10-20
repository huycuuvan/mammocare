<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 */
class Tab extends \yii\db\ActiveRecord
{
    public $file;

    use HasImgTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'type', 'lang_id'], 'required'],
            [['name', 'path'], 'string'],
            [['type', 'lang_id', 'ord'], 'integer'],
            [['code'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF,jpeg,JPEG','checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
     public function attributeLabels()
     {
         return [
             'id' => '#',
             'name' => 'Nội dung',
             'code' => 'Mã tab',
             'path' => 'Ảnh',
             'type' => 'Kiểu dữ liệu',
             'ord' => 'Thứ tự',
             'lang_id' => 'Ngôn ngữ'
         ];
     }

     public function getLanguage()
     {
         return $this->hasOne(Language::className(), ['id' => 'lang_id']);
     }

     public static function getType()
     {
       return [
         1 => 'Text',
         2 => 'Ảnh',
       ];
     }

     public static function getTypeName($type)
     {
       $arr = self::getType();

       return isset($arr[$type]) ? $arr[$type] : '';
     }

     public static function getTabs()
     {
         $_arr = [];
         $model = Tab::find()
         ->where(['{{language}}.code' => Yii::$app->language])
         ->joinWith(['language'])
         ->all();
         if (!empty($model)) {
             foreach ($model as $row) {
                if ($row->type == 2) {
                  $_arr[$row->code] = [
                    'path' => $row->path,
                    'title' => $row->name
                  ];
                } else {
                  $_arr[$row->code] = $row->name;
                }
             }
         }

         return $_arr;
     }

     public static function getTabsByLang($lang)
     {
         $model = Tab::find()
         ->where(['{{language}}.id' => $lang])
         ->joinWith(['language'])
         ->all();

         return $model;
     }

     public static function getTabByKeyLang($key, $lang)
     {
         $model = Tab::find()
         ->where(['{{tab}}.code' => $key, '{{language}}.id' => $lang])
         ->joinWith(['language'])
         ->one();

         return $model;
     }
}
