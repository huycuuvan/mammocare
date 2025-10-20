<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name'], 'string'],
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
        ];
    }
    public static function getAllProvinceDDL()
    {

        $arr = [];
        $parent = Province::find()
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
