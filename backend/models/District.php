<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $province_id
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'province_id'], 'required'],
            [['name'], 'string'],
            [['province_id'], 'integer'],
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
            'province_id' => 'Tỉnh / Thành phố',
        ];
    }

    public static function getAllDistrictDDL()
    {

        $arr = [];
        $parent = District::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (!empty($parent)) {
            foreach ($parent as $item) {
                $arr[$item->id] = $item->name;
            }
        }
        return $arr;
    }
    public static function getDistrictDDL($province_id)
    {

        $arr = [];
        $parent = District::find()
            ->where(['province_id'=> $province_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (!empty($parent)) {
            foreach ($parent as $item) {
                $arr[$item->id] = $item->name;
            }
        }
        return $arr;
    }
    public static function getDistrict($provine_id)
    {
        return District::find()
            ->where(['province_id' => $provine_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }
}
