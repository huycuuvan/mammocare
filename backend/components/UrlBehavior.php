<?php
namespace backend\components;

use yii\base\InvalidCallException;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use backend\components\MyExt;

class UrlBehavior extends AttributeBehavior
{
    /*
    * Thuộc tính được thay thế các ký tự không dấu
    */
	public $urlAttribute = "url";

    /*
    * Thuộc tính của $owner được lấy dữ liệu đầu vào
    */
    public $byValue = "name";

	public function init()
    {
        parent::init();
        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->urlAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->urlAttribute,
            ];
        }
    }

    protected function getValue($event)
    {
        $tmp_value = $this->byValue;
        $tmp_url = $this->urlAttribute;
        if ($this->value === null && !empty($this->owner->$tmp_value) && empty($this->owner->$tmp_url)) {
            return MyExt::removeSign($this->owner->$tmp_value);
        }

        if (!empty($this->owner->$tmp_url))
            return MyExt::removeSign($this->owner->$tmp_url);

        return parent::getValue($event);
    }
}
?>