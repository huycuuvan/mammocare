<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use backend\models\HasImgTrait;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "Place".
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
class Place extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb;

    use HasImgTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'place';
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
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF,jpeg, JPEG','checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Địa điểm',
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

    public static function getPlaceDDL()
    {
        return ArrayHelper::map(Place::find()->where('active=1')->asArray()->all(), 'id', 'name');
    }

    public static function getAllPlace() 
    {
        return Place::find()
        ->where(['{{place}}.active' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    
    public static function getHome()
    {
        return Place::find()
        ->where(['{{place}}.active' => 1, '{{place}}.home' => 1,  '{{language}}.code' => Yii::$app->language])
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
      return Url::toRoute(['site/list-place', 'id' => $this->id, 'name' => $this->url,'page'=>1]);
    }

    public static function getPlaceoption($selected=0)
    {

        $string='<option value="0">Tất cả</option>';
        $parent = Place::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (!empty($parent)) {
            foreach ($parent as $item) {
                $string.='<option '.($item->id==$selected?'selected':'').' value="'.$item->id.'">'.$item->name.'</div>';
            }
        }
        echo $string;
    }

}
