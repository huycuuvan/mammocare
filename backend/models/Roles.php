<?php

namespace backend\models;

use Yii;
use backend\models\Task;
use yii\behaviors\TimestampBehavior;
use backend\components\UrlBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string $name
 * @property string $roles_list
 * @property string $task_ids
 * @property string $task_str
 * @property string $created_date
 * @property string $updated_date
 * @property int $active
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_date', 'updated_date'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_date'],
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
            [['name'], 'required'],
            [['task_ids', 'task_str'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['active'], 'integer'],
            [['name', 'roles_list'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Vai trò',
            'roles_list' => 'Danh sách vai trò',
            'created_date' => 'Ngày tạo',
            'updated_date' => 'Ngày cập nhật',
            'active' => 'Kích hoạt',
            'task_ids' => 'Mã quyền',
            'task_str' => 'Danh sách quyền'
        ];
    }

    public function checked($task_id)
    {
        if (!empty($this->task_ids) && is_array($this->task_ids)) {
            return in_array($task_id, $this->task_ids);
        }

        return false;
    }

    /*
     * Trả về chuỗi quyền
     */
    public function getTaskStr()
    {
        $_arr = [];

        $task = Task::getTask();
        foreach ($task as $row) {
            $sub_task = Task::find()->where('parent = '.$row->id.' AND id IN ('.$this->task_ids.')')->all();
            if (!empty($sub_task)) {
                $_arr[$row->tblname] = [];
                foreach ($sub_task as $item) {
                    $_arr[$row->tblname][] = $item->tblname;
                }
            }
        }

        return serialize($_arr) ;
    }
}
