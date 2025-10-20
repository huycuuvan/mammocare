<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "property_value".
 *
 * @property int $id
 * @property string $name
 * @property int $ord
 * @property int $property_id
 */
class PropertyValue extends \yii\db\ActiveRecord
{
    public $file;
    public $thumb;

    use HasImgTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'property_id'], 'required'],
            [['ord', 'property_id'], 'integer'],
            [['name','code','p_from','p_to'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF'],
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
            'path' => 'Ảnh',
            'ord' => 'Thứ tự',
            'property_id' => 'Thông số',
            'file' => 'Chọn ảnh',
            'thumb' => 'Ảnh',
            'code'=>'Mã màu',
            'p_from'=>'Giá từ',
            'p_to'=>'Giá đến',
        ];
    }

    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
    public static function getPropertyValue($property_id)
    {
        return PropertyValue::find()
            ->where(['property_id' => $property_id])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->asArray()->all();
    }
    public static function getPriceoption($selected=0)
    {

        $string='<option value="0">Tất cả</option>';
        $parent = PropertyValue::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (!empty($parent)) {
            foreach ($parent as $item) {
                $string.='<option '.($item->id==$selected?'selected':'').' value="'.$item->id.'">'.$item->name.'</div>';
            }
        }
        echo $string;
    }

    public static function getPropertyValueDDL($property_id)
    {
        return ArrayHelper::map(self::getPropertyValue($property_id), 'id', 'name');
    }

    public static function getPropertyName($id)
    {
        $model = self::findOne($id);
        return $model->name;
    }

    public function getPropertyProduct()
    {
        return $this->hasMany(PropertyProduct::className(), ['property_value_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    public function delete()
    {
        foreach ($this->propertyProduct as $row) {
            $row->delete();
        }

        return parent::delete();
    }
}
