<?php

namespace backend\models;

use Yii;
use backend\components\MyExt;
use yii\imagine\Image;

/**
 * This is the model class for table "configure".
 *
 * @property int $id
 * @property int $newsperpage Số bài viết phân trang
 * @property int $prodperpage Số sản phẩm phân trang
 * @property int $orther_prod_num
 * @property int $hot_prod_num
 * @property int $home_prod_num
 * @property int $hot_news_num
 * @property int $latest_news_num
 * @property string $currency_format
 * @property string $replace_price
 * @property string $favicon
 * @property string $geo_meta
 * @property string $google_analytics
 * @property string $google_remarketing
 * @property string $boxchat
 * @property string $facebook_skd
 * @property string $app_id
 * @property string $admin_id
 * @property string $facebook_url
 * @property string $googleplus_url
 * @property string $twitter_url
 * @property string $youtube_url
 * @property string $smtp_email
 * @property string $smtp_name
 * @property string $smtp_pass
 * @property string $smtp_host
 */
class Configure extends \yii\db\ActiveRecord
{
    public $file;
    public $robots_path = 'robots.txt';
    public $robots_text;

    public function init()
    {
        /*
         * Khởi tạo giá trị mặc định cho file robots.txt
         */
        $robots_file = Yii::getAlias('@root').'/'.$this->robots_path;
        if (!file_exists($robots_file)) {
            $this->robots_text = 'User-agent: *
            Disallow: /images/
            Sitemap: '.MyExt::getDomain().'/sitemap.xml';
        } else {
            $this->robots_text = file_get_contents($robots_file);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_per_page', 'prod_per_page', 'orther_prod_num', 'home_news_num','hot_prod_num', 'home_prod_num', 'hot_news_num', 'latest_news_num', 'product_thumb_width', 'product_thumb_height', 'all_thumb_width', 'all_thumb_height', 'max_width', 'max_height', 'sender_label', 'email_label', 'mailgun_key', 'mailgun_domain', 'send_by_gmail'], 'required'],
            [['news_per_page', 'prod_per_page', 'orther_prod_num', 'hot_prod_num', 'home_prod_num', 'hot_news_num', 'latest_news_num', 'product_thumb_width', 'product_thumb_height', 'all_thumb_width', 'all_thumb_height', 'max_width', 'max_height', 'send_by_gmail', 'phone_widget', 'hotline_widget', 'editorbuilder'], 'integer'],
            [['head_tag', 'closed_head_tag', 'body_tag', 'closed_body_tag', 'robots_text','zalo_url','wechat_url','viber_url','boxchat','color_widget', 'tiktok_url', 'weixin_url', 'instagram_url'], 'string'],
            [['currency_format'], 'string', 'max' => 10],
            [['replace_price', 'favicon', 'facebook_url', 'twitter_url', 'youtube_url', 'sender_label', 'email_label', 'mailgun_key', 'mailgun_domain', 'smtp_email', 'smtp_port', 'smtp_secure', 'smtp_pass', 'smtp_host'], 'string', 'max' => 255],
//            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,webp,PNG,JPG,GIF,WEBP,jpeg,JPEG,jfif,JFIF','checkExtensionByMimeType' => false],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'news_per_page' => 'Bài viết / trang',
            'prod_per_page' => 'Sản phẩm / trang',
            'orther_prod_num' => 'Sản phẩm khác',
            'hot_prod_num' => 'Sản phẩm nổi bật',
            'best_prod_num' => 'Sản phẩm bán chạy',
            'home_prod_num' => 'Sản phẩm trang chủ',
            'hot_news_num' => 'Bài viết liên quan',
            'latest_news_num' => 'Bài viết mới nhất',
            'home_news_num' => 'Bài viết trang chủ',
            'currency_format' => 'Định dạng tiền tệ',
            'replace_price' => 'Giá trị thay thế',
            'editorbuilder' => 'Trình soạn thảo nâng cao',
            'favicon' => 'Favicon',
            'head_tag' => 'Dưới thẻ <head>',
            'closed_head_tag' => 'Trên thẻ </head>',
            'body_tag' => 'Dưới thẻ <body>',
            'closed_body_tag' => 'Trên thẻ </body>',
            'facebook_url' => 'Facebook Url',
            'twitter_url' => 'Alibaba Url',
            'youtube_url' => 'Youtube Url',
            'viber_url' => 'Whatsapp Url',
            'sender_label' => 'Tên người gửi',
            'email_label' => 'Email nhãn',
            'mailgun_key' => 'Key mailgun',
            'mailgun_domain' => 'Domain mailgun',
            'smtp_email' => 'Email gửi',
            'smtp_pass' => 'Mật khẩu',
            'smtp_host' => 'Host gửi',
            'smtp_secure' => 'Kiểu bảo mật',
            'smtp_port' => 'Cổng gửi',
            'send_by_gmail' => 'Chọn công cụ gửi',
            'file' => 'Chọn Icon',
            'product_thumb_width' => 'Chiều rộng thumb',
            'product_thumb_height' => 'Chiều cao thumb',
            'all_thumb_width' => 'Chiều rộng thumb',
            'all_thumb_height' => 'Chiều cao thumb',
            'max_width' => 'Chiều rộng max',
            'max_height' => 'Chiều cao max',
            'phone_widget' => 'Bật widget liên hệ',
            'hotline_widget' => 'Bật widget hotline',
            'color_widget' => 'Mã màu',
            'wechat_url'=>'Facebook Messenger',
            'boxchat'=>'Mã Chat',
            'tiktok_url' => 'Tiktok Url',
            'weixin_url' => 'Wechat Url',
            'instagram_url' => 'Instagram Url',
        ];
    }

    /*
     * Upload function send image to server
     */
    public function upload()
    {
        if ($this->validate()) {

            // Upload logo
            if (!empty($this->file->name)) {

                /*----Create folder of image if it isn't existed----*/
                $folder = 'upload/'.$this::tableName().'/';
                if(!is_dir(Yii::getAlias('@root').'/'.$folder)) {
                    mkdir(Yii::getAlias('@root').'/'.$folder);
                }

                /*----Remove old images if existed----*/
                if (!empty($this->favicon)) {
                    $path = Yii::getAlias('@root').'/'.$this->favicon;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $path = $folder.rand(3, 9999).MyExt::removeSign($this->file->baseName).'.'.$this->file->extension;
                /*----Save orginal image----*/
                Image::resize($this->file->tempName, 500, 500)->save(Yii::getAlias('@root').'/'.$path, ['jpeg_quality' => 100]);
                /*----Save image into database----*/
                $this->favicon = $path;
            }

            return true;
        }
        return false;
    }

    /*
     * Cập nhật giá trị mặc định cho file robots.txt
     */
    public function updateRobots()
    {
        $robots_file = Yii::getAlias('@root').'/'.$this->robots_path;
		$handle = fopen($robots_file, 'w') or die('Cannot open file: '.$robots_file);
		file_put_contents($robots_file, $this->robots_text);
		fclose($handle);
    }

    /*
     * Xóa hình ảnh được truyền vào qua tham số $path_url
     * Sử dụng khi 1 record có chứa ảnh bị xóa hoặc xóa ảnh đại diện của 1 tin tức
     */
    public function deleteImg($path_url)
    {
        $path = Yii::getAlias('@root').'/'.$path_url;

        if (file_exists($path)) {
            unlink($path);
        }
    }

    public static function getConfigure()
    {
        return Configure::find()->one();
    }
}
