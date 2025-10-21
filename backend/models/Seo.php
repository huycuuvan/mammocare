<?php

namespace backend\models;
use yii\helpers\Url;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property int $id
 * @property int $type
 * @property string $title
 * @property string $meta_keyword
 * @property string $meta_description
 */
class Seo extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb;

    use HasImgTrait;

    const HOME_PAGE = 1;
    const PRODUCT_PAGE = 2;
    const CONTACT_PAGE = 3;
    const GALLERY_PAGE = 4;
    const SEARCH_PAGE = 5;
    const SHOP_PAGE = 6;
    const ORDER_PAGE = 7;
    const VIDEO_PAGE = 8;
    const HOSTING_PAGE = 9;
    const DOMAIN_PAGE = 10;
    const EMAIL_PAGE = 11;
    const ABOUT_PAGE = 12;
    const CUSTOM_PAGE = 13;
    const TEMPLATE_PAGE = 14;
    const APP_PAGE = 15;
    const THANK_PAGE = 16;
    const DOCTOR_PAGE = 17;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'site_title', 'site_desc', 'lang_id'], 'required'],
            [['type', 'lang_id'], 'integer'],
            [['site_keyword', 'site_desc'], 'string'],
            [['site_title', 'path'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF,jpeg,JPEG','checkExtensionByMimeType' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'type' => 'Trang',
            'path' => 'Ảnh',
            'site_title' => 'Tiều đề',
            'site_keyword' => 'Meta Keyword',
            'site_desc' => 'Meta Description',
            'file' => 'Chọn ảnh',
            'thumb' => 'Ảnh',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    //receive types of category array
    public static function getPageDDL()
    {
        $arr = [
            Seo::HOME_PAGE => 'Trang chủ',
            Seo::CONTACT_PAGE => 'Liên hệ',
            Seo::SEARCH_PAGE  => 'Tìm kiếm',
            Seo::APP_PAGE  => 'Đặt lịch',
//            Seo::ORDER_PAGE  => 'Đặt hàng',
//            Seo::THANK_PAGE  => 'Cảm ơn',
        ];

//        $cat_pro = Cat::getParent();
//        if (!empty($cat_pro))
//        {
            $arr[Seo::PRODUCT_PAGE] = 'Phòng nổi bật';
//            $arr[Seo::ORDER_PAGE] = 'Đặt hàng';
//            $arr[Seo::SHOP_PAGE] = 'Giỏ hàng';
//        }
//
        if (Album::find()->count() > 0)
            $arr[Seo::GALLERY_PAGE] = 'Thư viện ảnh';

        if (Video::find()->count() > 0)
            $arr[Seo::VIDEO_PAGE] = 'Video';

        return $arr;
    }

    //receive types of category array
    public static function getUrl()
    {
        return [
            Seo::HOME_PAGE => Yii::$app->urlManagerFrontend->baseUrl,
//            Seo::PRODUCT_PAGE => Yii::$app->urlManagerFrontend->createUrl('site/all-product'),
            Seo::CONTACT_PAGE => Yii::$app->urlManagerFrontend->createUrl('site/contact'),
            Seo::GALLERY_PAGE => Yii::$app->urlManagerFrontend->createUrl('site/gallery'),
            Seo::SEARCH_PAGE  => Yii::$app->urlManagerFrontend->createUrl('site/search-news'),
            Seo::VIDEO_PAGE  => Yii::$app->urlManagerFrontend->createUrl('site/video'),
        ];
    }
    public static function getUrls($type)
    {
        switch ($type) {
            case Seo::HOME_PAGE : return Yii::$app->urlManagerFrontend->baseUrl; break;
            case Seo::PRODUCT_PAGE : return Yii::$app->urlManagerFrontend->createUrl('site/all-product'); break;
            case Seo::CONTACT_PAGE : return Yii::$app->urlManagerFrontend->createUrl('site/contact'); break;
            case Seo::GALLERY_PAGE : return Yii::$app->urlManagerFrontend->createUrl('site/gallery'); break;
            case Seo::SEARCH_PAGE  : return Yii::$app->urlManagerFrontend->createUrl('site/search'); break;
            case Seo::SHOP_PAGE  : return Yii::$app->urlManagerFrontend->createUrl('site/shopping-cart'); break;
            case Seo::VIDEO_PAGE  : return Yii::$app->urlManagerFrontend->createUrl('site/videos'); break;
        }
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public static function getSeo($type_id)
    {
        return Seo::find()->where(['type' => $type_id, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])->one();
    }
}
