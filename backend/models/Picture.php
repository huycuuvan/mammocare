<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use backend\models\Album;

/**
 * This is the model class for table "picture".
 *
 * @property int $id
 * @property string $path
 * @property int $home
 * @property int $ord
 */
class Picture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'picture';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression("NOW()"),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'album_id'], 'required'],
            [['created_at'], 'safe'],
            [['home', 'ord', 'album_id'], 'integer'],
            [['path', 'alt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'path' => 'Ảnh',
            'alt' => 'Thẻ alt',
            'home' => 'Trang chủ',
            'ord' => 'Thứ thự',
            'created_at' => 'Ngày tạo',
            'album_id' => 'Album'
        ];
    }

    /*
     * Viết lại delete function của Product class
     * Xóa ảnh mà bản ghi này có
     */
    public function delete()
    {
        if (isset($this->path)) {
            $thumb_path = Yii::getAlias('@root').'/'.$this->path;
            $img_path = str_replace("thumb/", "", $thumb_path);
            if (file_exists($img_path)) {
                unlink($img_path);
            }

            if (file_exists($thumb_path)) {
                unlink($thumb_path);
            }
        }

        return parent::delete();
    }

    public function getAlbum()
    {
        return $this->hasOne(Album::className(), ['id' => 'album_id']);
    }
    public function getFullImg()
    {
      return str_replace('thumb/', '', $this->path);
    }

    public static function getPicture()
    {
        return Picture::find()
            ->where(['{{album}}.active' => 1])
            ->joinWith(['album'])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

}
