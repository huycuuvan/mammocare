<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ward".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $district_id
 */
class Ward extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ward';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'district_id'], 'required'],
            [['name'], 'string'],
            [['district_id'], 'integer'],
            [['code'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên',
            'code' => 'Mã',
            'district_id' => 'Quận Huyện',
        ];
    }

    public static function getWard($district_id)
    {
        return Ward::find()
            ->where(['district_id' => $district_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    public static function getWardDDL($district_id)
    {

        $arr = [];
        $parent = Ward::find()
            ->where(['district_id'=> $district_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (!empty($parent)) {
            foreach ($parent as $item) {
                $arr[$item->id] = $item->name;
            }
        }
        return $arr;
    }
}
