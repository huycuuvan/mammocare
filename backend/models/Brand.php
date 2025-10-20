<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use backend\models\HasImgTrait;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name tên hãng
 * @property string $path logo
 * @property string $url đường dẫn
 * @property string $description
 * @property int $ord
 * @property int $active
 * @property int $home
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_keyword
 */
class Brand extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb;

    use HasImgTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    public function behaviors()
    {
        return [
            'url' => [
                'class' => UrlBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lang_id'], 'required'],
            [['description', 'seo_desc', 'seo_keyword'], 'string'],
            [['ord', 'active', 'home', 'lang_id'], 'integer'],
            [['name', 'path', 'url', 'seo_title'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tiện ích',
            'path' => 'Ảnh',
            'url' => 'Liên kết',
            'description' => 'Mô tả',
            'ord' => 'Thứ tự',
            'active' => 'Hiển thị',
            'home' => 'Trang chủ',
            'seo_title' => 'Tiêu đề SEO',
            'seo_desc' => 'Mô tả SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'thumb' => 'Ảnh',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->seo_title)
            $this->seo_title = $this->name;

        if (!$this->seo_desc)
            $this->seo_desc = (!$this->description) ? $this->name : substr(strip_tags($this->description), 0, 320);

        return parent::beforeSave($insert);
    }

    public static function getBrandDDL()
    {
        return ArrayHelper::map(Brand::find()->where('active=1')->asArray()->all(), 'id', 'name');
    }

    public static function getAllBrand() 
    {
        return Brand::find()
        ->where(['{{brand}}.active' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    
    public static function getHome()
    {
        return Brand::find()
        ->where(['{{brand}}.active' => 1, '{{brand}}.home' => 1,  '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public function getUrl()
    {
      return Url::toRoute(['site/list-product', 'brand_id' => $this->id, 'brand_name' => $this->url,'page'=>1]);
    }

}
