<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $job
 * @property string $content
 * @property int $ord
 * @property int $active
 */
class Comment extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb;

    use HasImgTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'content', 'lang_id'], 'required'],
            [['content'], 'string'],
            [['ord', 'active', 'lang_id'], 'integer'],
            [['name', 'path', 'job'], 'string', 'max' => 200],
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
            'name' => 'Họ tên',
            'path' => 'Ảnh',
            'job' => 'Vị trí',
            'content' => 'Nội dung',
            'ord' => 'Thứ tự',
            'active' => 'Hiển thị',
            'thumb' => 'Ảnh',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public static function getComment()
    {
        return Comment::find()
        ->where(['{{comment}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->orderBy('ord asc, id desc')
        ->joinWith(['language'])
        ->all();
    }
}
