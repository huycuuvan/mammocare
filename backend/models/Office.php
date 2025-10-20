<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "Office".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $content
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_keyword
 * @property int $active
 */
class Office extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb;

    use HasImgTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'office';
    }

    public function behaviors()
    {
        return [
            'url' => [
                'class' => UrlBehavior::className(),
                'byValue' => 'title'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id', 'city_id', 'lang_id'], 'required'],
            [['content', 'seo_desc', 'seo_keyword', 'latitude', 'longitude'], 'string'],
            [['active', 'user_id', 'city_id', 'ord', 'home', 'lang_id'], 'integer'],
            [['title', 'url', 'seo_title'], 'string', 'max' => 200],
            [['address', 'path'], 'string'],
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
            'title' => 'Tên đại lý',
            'url' => 'Đường dẫn',
            'path' => 'Ảnh',
            'content' => 'Nội dung',
            'address' => 'Địa chỉ',
            'seo_title' => 'Tiêu đề SEO',
            'seo_desc' => 'Mô tả SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'active' => 'Hiển thị',
            'latitude' => 'Vĩ độ',
            'longitude' => 'Kinh độ',
            'home' => 'Trang chủ',
            'ord' => 'Thứ tự',
            'city_id' => 'Thành phố',
            'user_id' => 'Người tạo',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public static function getHomeOffice()
    {
        return Office::find()
        ->where(['{{office}}.active' => 1, '{{office}}.home' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }

    public static function getOfficeByCity($city_id)
    {
        return Office::find()
        ->where(['{{office}}.active' => 1, '{{office}}.city_id' => $city_id, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }

    public function getUrl()
    {
        return Url::toRoute(['site/agency', 'id' => $this->id, 'name' => $this->url]);
    }

}
