<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "cat_news".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $position
 * @property int $active
 * @property int $home
 * @property int $ord
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_keyword
 * @property int $parent
 */
class CatNews extends \yii\db\ActiveRecord
{
    const BOX_POS = 1;
    const BOX_HOME=2;

    public $file;
    public $thumb;

    use HasImgTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_news';
    }

    public function behaviors()
    {
        return [
            [
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
            [['name', 'lang_id','url'], 'required'],
            [['position', 'active', 'home', 'ord', 'parent', 'lang_id'], 'integer'],
            [['path', 'seo_desc', 'seo_keyword'], 'string'],
            [['parent'], 'default', 'value'=> 0],
            [['name', 'url', 'seo_title'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF','checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên danh mục',
            'url' => 'Đường dẫn',
            'path' => 'Ảnh',
            'position' => 'Vị trí',
            'active' => 'Hiển thị',
            'home' => 'Trang chủ',
            'ord' => 'Thứ tự',
            'seo_title' => 'Tiêu đề SEO',
            'seo_desc' => 'Mô tả SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'parent' => 'Danh mục cha',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    //receive types of category array
    public static function getPosition()
    {
        return [
            self::BOX_POS => 'Box Tin trái',
            self::BOX_HOME => 'Box Tin phải'
        ];
    }

    //receive position name
    public static function getPositionName($pos)
    {
        $posName = self::getPosition();

        return $posName[$pos];
    }

    /*-------Trả về danh mục cha------*/
    public function getFather()
    {
        return $this->hasOne(CatNews::className(), ['id' => 'parent']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    /*--------Quản lý menu trong quản trị*/
    public static function getAdmin()
    {
        return CatNews::find()
        ->where(['parent' => 0,'{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    public static function getParent()
    {
        return CatNews::find()
        ->where(['parent' => 0,'{{cat_news}}.active'=>1,'{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }

    //lay danh muc con theo danh muc cha
    public function getSubAdmin()
    {
        return CatNews::find()
            ->where(['parent' => $this->id])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    public static function getAdminByPosition($pos)
    {
        return CatNews::find()
        ->where(['parent' => 0, 'position' => $pos, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }


    /*-------Trả về dữ liệu cho DropDownList form tin tức------*/
    public static function getAllCatNewsDDL()
    {
        return self::getCatNewsDDL();
    }

    /*-------Lấy danh sách danh mục cha------*/
    public static function getCatNews()
    {
        return self::find()
        ->where(['{{cat_news}}.active' => 1, 'parent' => 0,  '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }


    public static function getCatHome()
    {
        return self::find()
        ->where(['{{cat_news}}.active' => 1, 'home' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }


    public static function getCatHomeByPos($pos=CatNews::BOX_POS)
    {
        return self::find()
            ->where(['{{cat_news}}.active' => 1,'position'=>$pos, 'parent'=>0, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    /*-------Trả về dữ liệu cho DropDownList form danh mục cha------*/
    public static function getCatNewsDDL()
    {

        $arr = [];
        $parent = CatNews::find()
        ->where(['{{cat_news}}.active' => 1, 'parent' => 0, '{{language}}.code' => Yii::$app->language])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->joinWith(['language'])
        ->all();

        if (!empty($parent)) {
            foreach ($parent as $item) {
//                $arr['Danh mục'][$item->id] = $item->name;
//
//                foreach($item->getSubAdmin() as $child) {
//                  $arr['Danh mục'][$child->id] = '|---' . $child->name;
//                }
                $arr[$item->id] = $item->name;

                foreach($item->getSubAdmin() as $child) {
                  $arr[$child->id] = '|---' . $child->name;

                  foreach($child->getSubAdmin() as $child1) {
                    $arr[$child1->id] = '|------' . $child1->name;
                  }
                }
            }
        }

//        foreach (self::getPosition() as $key => $val) {
//          $catList = self::getAdminByPosition($key);
//
//          foreach ($catList as $item) {
//              $arr[$val][$item->id] = $item->name;
//
//              foreach($item->getSubAdmin() as $child) {
//                $arr[$val][$child->id] = '|---' . $child->name;
//              }
//          }
//        }

        return $arr;
    }

    public function getUrl($page=1)
    {
      return Url::toRoute(['site/list-news', 'id' => $this->id, 'name' => $this->url,'page'=>$page]);
    }

    public function getSubCat()
    {
        return self::find()
            ->where(['active' => 1, 'parent' => $this->id])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    public static function countNews($id)
    {
        return Yii::$app->db
            ->createCommand('SELECT count(*) FROM news AS n INNER JOIN language AS l ON `n`.`lang_id` = `l`.`id` WHERE `l`.`code` = "' . Yii::$app->language . '" and cat_id='.$id.' and `n`.`active`=1')
            ->queryScalar();
    }
}
