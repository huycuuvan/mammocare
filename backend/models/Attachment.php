<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "attachment".
 *
 * @property int $id
 * @property string $path
 * @property int $ord
 * @property int $pid
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path'], 'required'],
            [['ord', 'pid'], 'integer'],
            [['path'], 'string', 'max' => 200],
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
            'ord' => 'Thứ tự',
            'pid' => 'Sản phẩm',
        ];
    }

    /*
     * Viết lại delete function của Product class
     * Xóa ảnh mà bản ghi này có
     */
    public function delete()
    {
        if (isset($this->path)) {
            $thumb_path = Yii::getAlias('@root') . '/' . $this->path;
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

    public static function getTempImgs()
    {
        return Yii::$app->db->createCommand('SELECT * FROM attachment WHERE pid NOT IN (SELECT DISTINCT id FROM product)')->queryAll();
    }

    public function getFullImg()
    {
        return str_replace('/thumb', '', $this->path);
    }

    public static function getPathById($id)
    {
        $model = self::findOne($id);
        return $model->path;
    }

    public static function getImgDDLByProduct($id)
    {
        $imgs = Attachment::find()->where(['pid' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $arr = [];
        if (!empty($imgs)) {
            foreach ($imgs as $i => $row) {
                $arr[] = [
                    "id" => $row->id,
                    "path" => $row->path,
                ];
            }
        }
        return $arr;
    }

    public static function getImgsAlone()
    {
        $imgs = Attachment::find()->where('pid NOT IN (SELECT DISTINCT id FROM product)')
        ->orderBy(['id' => SORT_DESC])
        ->all();

        return $imgs;
    }
}
