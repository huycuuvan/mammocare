<?php

namespace backend\models;

use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property int $ord
 * @property int $cat_id
 * @property int $active
 */
class Property extends \yii\db\ActiveRecord
{
    public $json_values;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lang_id'], 'required'],
            [['ord', 'active', 'type_id', 'lang_id','has_image'], 'integer'],
            [['has_image'], 'default', 'value'=> 0],
            [['name'], 'string', 'max' => 200],
            [['json_values'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên thuộc tính',
            'ord' => 'Thứ tự',
            'active' => 'Hiển thị',
            'type_id' => 'Kiểu',
            'lang_id' => 'Ngôn ngữ',
            'has_image'=>'Gán ảnh'
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $json_data = json_decode($this->json_values);
        $hasValue = [];

        if (!empty($json_data)) {
            foreach ($json_data as $row) {
                if ($row->id) {
                    $model = PropertyValue::findOne((int) $row->id);
                    if (!empty($model)) {
                        $model->name = $row->name;
                        $model->ord = $row->ord;
                        $model->save();
                    }
                } else {
                    $model = new PropertyValue;
                    $model->name = $row->name;
                    $model->ord = $row->ord;
                    $model->property_id = $this->id;
                    $model->save();
                }

                $hasValue[] = $model->id;
            }
        }

        //Delete old value
        $model = PropertyValue::find()->where(['property_id' => $this->id])->all();
        foreach ($model as $row) {
            if (!in_array($row->id, $hasValue))
                $row->delete();
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    public function loadValue()
    {
        $model = PropertyValue::find()->where(['property_id' => $this->id])->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->all();
        if (!empty($model)) {
            $value_arr = [];
            foreach ($model as $row) {
                $value_arr[] = ['id' => $row->id, 'name' => $row->name, 'ord' => $row->ord];
            }
            $this->json_values = json_encode($value_arr);
        }
    }

    public static function getProperty()
    {
        $model = Property::find()
        ->joinWith(['language'])
        ->where(['{{property}}.active' => 1, '{{language}}.code' => Yii::$app->language])
        ->orderBy(['{{property}}.ord' => SORT_ASC, '{{property}}.id' => SORT_DESC])->all();

        return $model;
    }

    public static function getPropertyDDL()
    {
        return ArrayHelper::map(self::getProperty(), 'id', 'name');
    }

    public static function getPropertyName($id)
    {
        $model = Property::findOne($id);

        return $model->name;
    }

    public function getPropertyValue()
    {
        return $this->hasMany(PropertyValue::className(), ['property_id' => 'id'])->orderBy(['ord' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public function getPropertyProduct()
    {
        return $this->hasMany(PropertyProduct::className(), ['property_id' => 'id']);
    }

    public function delete()
    {
        foreach ($this->propertyValue as $row) {
            $row->delete();
        }

        foreach ($this->propertyProduct as $row) {
            $row->delete();
        }

        return parent::delete();
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
}
