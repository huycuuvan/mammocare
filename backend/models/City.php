<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "City".
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
class City extends \yii\db\ActiveRecord
{
    const BOX_INLAND = 1;
    const BOX_FOREIGN = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
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
            [['name', 'lang_id', 'position'], 'required'],
            [['position', 'active', 'home', 'ord', 'parent', 'zoom', 'lang_id'], 'integer'],
            [['seo_desc', 'seo_keyword'], 'string'],
            [['parent'], 'default', 'value'=> 0],
            [['name', 'url', 'latitude', 'longitude', 'seo_title'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên thành phố',
            'url' => 'Đường dẫn',
            'position' => 'Vị trí',
            'latitude' => 'Vĩ độ',
            'longitude' => 'Kinh độ',
            'zoom' => 'Zoom',
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
          self::BOX_INLAND => 'Trong nước',
        //   self::BOX_FOREIGN => 'Nước ngoài',
        ];
    }

    //receive type name
    public static function getPositionName($pos)
    {
        $arr = self::getPosition();
        return $arr[$pos];
    }

    /*-------Trả về danh mục cha------*/
    public function getFather()
    {
        return $this->hasOne(City::className(), ['id' => 'parent']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    /*--------Quản lý menu trong quản trị*/
    public static function getAdmin($pos)
    {
        return City::find()
        ->where(['parent' => 0, 'position' => $pos, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }

    //lay danh muc con theo danh muc cha
    public function getSubAdmin()
    {
        return City::find()
            ->where(['parent' => $this->id])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    /*-------Trả về dữ liệu cho DropDownList form tin tức------*/
    public static function getAllCityDDL()
    {
        $arr = [];

        $pos = City::getPosition();

        foreach($pos as $key => $value) {

          $parent = City::getAdmin($key);

          if (!empty($parent)) {
              foreach ($parent as $item) {
                  $arr[$value][$item->id] = $item->name;

                  foreach($item->getSubAdmin() as $child) {
                    $arr[$value][$child->id] = '|---' . $child->name;
                  }
              }
          }
        }

        return $arr;
    }

    /*-------Lấy danh sách danh mục cha------*/
    public static function getCity()
    {
        return self::find()
        ->where(['{{city}}.active' => 1, 'parent' => 0, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->all();
    }


    public static function getCatHome()
    {
        return self::find()
        ->where(['{{city}}.active' => 1, 'home' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->all();
    }


    /*-------Trả về dữ liệu cho DropDownList form danh mục cha------*/
    public static function getCityDDL()
    {
        return ArrayHelper::map(City::find()
        ->where(['{{city}}.active' => 1, 'parent' => 0, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->asArray()->all(), 'id', 'name');
    }

    /*-------Trả về dữ liệu cho DropDownList form danh mục cha------*/
    public static function getCityByPositionDDL($pos)
    {
        $arr = [];

        $parent = City::getAdmin($pos);

        if (!empty($parent)) {
          foreach ($parent as $item) {
            $arr[$item->id] = $item->name;

            foreach($item->getSubAdmin() as $child) {
              $arr[$child->id] = '|---' . $child->name;
            }
          }
        }

        return $arr;
    }

    public function getUrl()
    {
      return Url::toRoute(['site/list-news', 'id' => $this->id, 'name' => $this->url]);
    }
}
