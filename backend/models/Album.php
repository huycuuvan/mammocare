<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "album".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $brief
 * @property string $path
 * @property int $ord
 * @property int $home
 * @property int $active
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_keyword
 */
class Album extends \yii\db\ActiveRecord
{
    public $pid;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'album';
    }

    public function behaviors()
    {
        return [
          'url' => [
              'class' => UrlBehavior::className(),
          ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'path', 'lang_id'], 'required'],
            [['brief', 'seo_desc', 'seo_keyword'], 'string'],
            [['ord', 'home', 'active', 'pid', 'lang_id'], 'integer'],
            [['name', 'url', 'path', 'seo_title'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên album',
            'brief' => 'Mô tả',
            'path' => 'Ảnh',
            'ord' => 'Thứ tự',
            'home' => 'Trang chủ',
            'active' => 'Hiển thị',
            'url' => 'Đường dẫn',
            'seo_title' => 'Tiêu đề SEO',
            'seo_desc' => 'Mô tả SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'pid' => 'Mã album',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->seo_title)
            $this->seo_title = $this->name;

        if (!$this->seo_desc)
            $this->seo_desc = $this->name;

        return parent::beforeSave($insert);
    }

    /*
     * Viết lại delete function của Product class
     * Xóa tất cả các ảnh của sản phẩm này
     */
    public function delete()
    {
        $imgs = $this->imgs;
        if (!empty($imgs)) {
            foreach ($imgs as $row) {
                $row->delete();
            }
        }
        return parent::delete();
    }

    public function getImgs()
    {
        return $this->hasMany(Picture::className(), ['album_id' => 'id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public static function getHome()
    {
        return Album::find()
        ->where(['{{album}}.active' => 1, '{{album}}.home' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }

    public static function getAll()
    {
        return Album::find()
        ->where(['{{album}}.active' => 1,  '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }

    public function getUrl()
    {
      return Url::to(['site/album', 'id' => $this->id, 'name' => $this->url]);
    }

    public function getFullImg()
    {
      return str_replace('thumbnail/', '', $this->path);
    }
    public  function countPicture()
    {
        return Yii::$app->db
            ->createCommand('SELECT count(*) FROM picture AS n  WHERE  album_id='.$this->id)
            ->queryScalar();
    }
}
