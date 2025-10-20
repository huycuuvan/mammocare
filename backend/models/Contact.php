<?php

namespace backend\models;

use Yii;
use backend\components\MyExt;
use yii\imagine\Image;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $company_name
 * @property string $slogan slogan
 * @property string $address
 * @property string $phone
 * @property string $hotline
 * @property string $fax
 * @property string $email
 * @property string $email_bcc
 * @property string $about_title
 * @property string $about_content
 * @property string $about_url
 * @property string $footer
 * @property string $copyright
 * @property string $logo logo 1
 * @property string $logo_footer logo 2
 * @property string $payment welcome text
 * @property string $gift
 */
class Contact extends \yii\db\ActiveRecord
{
    public $img;
    public $img_footer;
    public $img_mobile;
    public $doc;
    public $del_doc;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'address', 'address2', 'phone', 'hotline', 'email', 'currency_format', 'replace_price', 'lang_id'], 'required'],
            [['about_content', 'footer', 'copyright', 'json_office', 'site_title', 'about_title', 'about_url', 'site_desc'], 'string'],
            [['del_doc', 'lang_id'], 'integer'],
            [['company_name', 'slogan', 'head_office', 'map', 'address', 'email', 'email_bcc', 'logo', 'logo_footer', 'logo_mobile'], 'string', 'max' => 255],
            [['phone', 'hotline', 'hotline2', 'hotline3', 'fax'], 'string', 'max' => 50],
            [['img', 'img_footer', 'img_mobile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF,jpeg,JPEG','checkExtensionByMimeType' => false],
            [['doc'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4,MP4'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'company_name' => 'Tên công ty',
            'slogan' => 'Slogan',
            'head_office' => 'Tên trụ sở',
            'address' => 'Địa chỉ',
            'address2' => 'Địa chỉ rút gọn',
            'map' => 'Vị trí bản đồ',
            'json_office' => 'Chi nhánh & Văn phòng',
            'phone' => 'Điện thoại',
            'hotline' => 'Hotline',
            'hotline2' => 'Hotline 2',
            'hotline3' => 'Hotline 3',
            'fax' => 'Fax',
            'email' => 'Email',
            'email_bcc' => 'Email Bcc',
            'site_title' => 'Tiêu đề Website',
            'site_desc' => 'Mô tả Website',
            'about_title' => 'Giao hàng COD',
            'about_content' => 'Bảo hành',
            'about_url' => 'Chuyển khoản',
            'footer' => 'Liên hệ',
            'copyright' => 'Bản quyền nội dung',
            'logo' => 'Logo',
            'logo_footer' => 'Logo Footer',
            'logo_mobile' => 'Logo Mobile',
            'img' => 'Chọn logo',
            'img_footer' => 'Chọn logo footer',
            'img_mobile' => 'Chọn logo mobile',
            'lang_id' => 'Ngôn ngữ',
            'replace_price' => 'Giá trị thay thế',
            'currency_format' => 'Định dạng tiền tệ',
            'path_file' => 'Tệp tin',
            'del_doc' => 'Xóa tệp tin',
        ];
    }

    /*
     * Upload function send image to server
     */
    public function upload()
    {
        if ($this->validate()) {

            if (!empty($this->img->name) || !empty($this->img_footer->name) || !empty($this->img_mobile->name)) {
                /*----Create folder of image if it isn't existed----*/
                $folder = 'upload/'.$this::tableName().'/';
                if(!is_dir(Yii::getAlias('@root').'/'.$folder)) {
                    mkdir(Yii::getAlias('@root').'/'.$folder);
                }
            }

            // Upload logo
            if (!empty($this->img->name)) {
                /*----Remove old images if existed----*/
                if (!empty($this->logo)) {
                    $path = Yii::getAlias('@root').'/'.$this->logo;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $path = $folder.rand(3, 9999).MyExt::removeSign($this->img->baseName).'.'.$this->img->extension;
                /*----Save orginal image----*/
                Image::resize($this->img->tempName, 700, 700)->save(Yii::getAlias('@root').'/'.$path, ['jpeg_quality' => 100]);
                /*----Save image into database----*/
                $this->logo = $path;
            }

            // Upload logo footer
            if (!empty($this->img_footer->name)) {
                /*----Remove old images if existed----*/
                if (!empty($this->logo_footer)) {
                    $path_footer = Yii::getAlias('@root').'/'.$this->logo_footer;
                    if (file_exists($path_footer)) {
                        unlink($path_footer);
                    }
                }

                $path_footer = $folder.rand(3, 9999).MyExt::removeSign($this->img_footer->baseName).'.'.$this->img_footer->extension;
                /*----Save orginal image----*/
                Image::resize($this->img_footer->tempName, 700, 700)->save(Yii::getAlias('@root').'/'.$path_footer, ['jpeg_quality' => 100]);
                /*----Save image into database----*/
                $this->logo_footer = $path_footer;
            }

            //Upload logo mobile
            if (!empty($this->img_mobile->name)) {
                /*----Remove old images if existed----*/
                if (!empty($this->logo_mobile)) {
                    $path_footer = Yii::getAlias('@root').'/'.$this->logo_mobile;
                    if (file_exists($path_footer)) {
                        unlink($path_footer);
                    }
                }

                $path_footer = $folder.rand(3, 9999).MyExt::removeSign($this->img_mobile->baseName).'.'.$this->img_mobile->extension;
                /*----Save orginal image----*/
                Image::resize($this->img_mobile->tempName, 700, 700)->save(Yii::getAlias('@root').'/'.$path_footer, ['jpeg_quality' => 100]);
                /*----Save image into database----*/
                $this->logo_mobile = $path_footer;
            }

            if (!empty($this->doc->name)) {

                if (!empty($this->path_file)) {
                    $path = Yii::getAlias('@root').'/'.$this->path_file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $folder = Yii::getAlias('@root') . '/';
                $filePath = 'upload/' . $this::tableName() . '/' . MyExt::removeSign($this->doc->baseName) . '.' . $this->doc->extension;

                $this->doc->saveAs($folder . $filePath, false);

                $this->path_file = $filePath;
            }
            else {
                if (!empty($this->del_doc)) {
                    if (!empty($this->path_file)) {
                        $path = Yii::getAlias('@root').'/'.$this->path_file;
                        if (file_exists($path)) {
                            unlink($path);
                        }

                        $this->path_file = '';
                    }
                }
            }

            return true;
        }
        return false;
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

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public static function getContact()
    {
        return Contact::find()
        ->where(['{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->one();
    }

    public static function getContactByLang($lang)
    {
        return Contact::find()
        ->where(['{{language}}.id' => $lang])
        ->joinWith(['language'])
        ->one();
    }
}
