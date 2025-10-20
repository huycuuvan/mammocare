<?php
namespace backend\models;
use Yii;
use backend\models\HasImgTrait;
/**
 * This is the model class for table "partner".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $content
 * @property string $url
 * @property int $position
 * @property int $ord
 * @property int $active
 */
class Partner extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb,$img,$doc;
    public $del_doc;
    const SLIDE = 1;
    const SLIDE_MOBILE = 2;
    const ABOUTUS = 3;
    const ABOUTLINK = 4;
    const COUNTER = 5;
    const COMMIT = 6;
    const SERVICE = 7;
    const CERTI = 8;
    const ADS = 9;
    const WHY = 10;
    const LINK = 11;
    const CONTACT = 12;
    const COMMENTCUS=13;
    use HasImgTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partner';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'position', 'lang_id'], 'required'],
            [['content', 'info', 'info2','path_file'], 'string'],
            [['position', 'ord', 'active', 'lang_id','home','del_doc'], 'integer'],
            [['name', 'path', 'url','background'], 'string', 'max' => 200],
            [['home'], 'default', 'value'=> 0],
            [['file','thumb','img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,webp,PNG,JPG,GIF,WEBP,jpeg,JPEG,jfif,JFIF,mp4,MP4','checkExtensionByMimeType' => false],
            [['doc'], 'file', 'skipOnEmpty' => true, 'extensions' => 'mp4,MP4,webm,WEBM','checkExtensionByMimeType' => false],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên hình ảnh / liên kết',
            'path' => 'Ảnh',
            'content' => 'Mô tả',
            'url' => 'Liên kết',
            'position' => 'Vị trí',
            'info' => 'Mô tả',
            'info2' => 'Mô tả ngắn',
            'ord' => 'Thứ tự',
            'active' => 'Hiển thị',
            'file' => 'Chọn ảnh',
            'img' => 'Chọn ảnh 2',
            'thumb' => 'Ảnh',
            'home'=>'T.chủ',
            'lang_id' => 'Ngôn ngữ',
            'doc'=>'Video',
            'del_doc' => 'Xóa tệp tin',
        ];
    }
    public static function getPosition()
    {
        return [
            self::SLIDE => 'Slide ảnh',
            self::SLIDE_MOBILE => 'Slide mobile',
            self::ABOUTUS => 'Giới thiệu',
            self::ABOUTLINK => 'Chữ ký',
            // self::COUNTER => 'Bộ đếm',
            self::SERVICE => 'Cơ sở vật chất',
            self::CERTI => 'Dịch vụ',
            self::WHY => 'Thư viện ảnh',
            self::LINK => 'Đối tác',
            self::COMMIT => 'Tư vấn dịch vụ',
            self::CONTACT => 'Hướng dẫn dịch vụ',
            self::ADS => 'Lịch khám',
            // self::LINK => 'Danh mục mobile',
        ];
    }
    public static function getPositionForm()
    {
        $arr = [];
        $parent = Partner::find()
            ->where(['{{partner}}.active' => 1, 'position'=>Partner::CERTI, '{{language}}.code' => Yii::$app->language])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->joinWith(['language'])
            ->all();
        if (!empty($parent)) {
            foreach ($parent as $item) {
                $arr[$item->id] = $item->name;
            }
        }
        return $arr;
    }
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
    public static function getPartner($position_id,$limit=100)
    {
        return Partner::find()
          ->where(['position' => $position_id, 'partner.active' => 1, '{{language}}.code' => Yii::$app->language])
          ->joinWith(['language'])
          ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->limit($limit)
          ->all();
    }
    public static function getPartnerHome($position_id,$limit=100)
    {
        return Partner::find()
          ->where(['position' => $position_id, 'partner.active' => 1, 'partner.home' => 1, '{{language}}.code' => Yii::$app->language])
          ->joinWith(['language'])
          ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->limit($limit)
          ->all();
    }
    public static function getPartnerParent($position_id)
    {
        return Partner::find()
          ->where(['position' => $position_id, 'partner.active' => 1,'parent'=>0, '{{language}}.code' => Yii::$app->language])
          ->joinWith(['language'])
          ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
          ->all();
    }
    public function getImg()
    {
        return Partner::find()
        ->where(['partner.active' => 1, 'parent' => $this->id,'position'=>self::IMG, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->all();
    }
    public static function getPartnerByLang($lang)
    {
        $model = Partner::find()
        ->where(['{{language}}.id' => $lang])
        ->joinWith(['language'])
        ->all();
        return $model;
    }
    public static function getDDL()
    {
        $arr = [];
        $parent =Partner::find()
            ->where(['position' => self::ADS])
            ->orderBy(['ord' => SORT_ASC,'id' => SORT_ASC])
            ->all();
        if (!empty($parent)) {
            foreach ($parent as $item) {
                $arr[$item->id] = $item->name;
            }
        }
        return $arr;
    }
}
