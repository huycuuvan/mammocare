<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property string $tblname
 * @property string $note
 * @property int $parent
 * @property int $related_id
 * @property int $ord
 * @property int $chose
 * @property int $first
 * @property int $active
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tblname'], 'required'],
            [['note'], 'string'],
            [['parent'], 'integer'],
            [['parent'], 'default', 'value'=> 0],
            [['name', 'tblname'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên module',
            'tblname' => 'Mã module',
            'note' => 'Ghi nhớ',
            'parent' => 'Module cha',
        ];
    }

    public function getChild()
    {
        return $this->hasMany(Task::className(), ['parent' => 'id']);
    }

    public static function getTask()
    {
        return Task::find()->where('parent = 0')->orderBy(['name' => SORT_ASC])->all();
    }
}
