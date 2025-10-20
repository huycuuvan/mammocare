<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use SimpleXMLElement;
use backend\components\MyExt;

/**
 * Login form
 */
class UpdateJs extends Model
{
    public $jsPath = 'bundle/js/custom.js';
    public $data = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['data', 'safe'],
        ];
    }

    public function init()
	{
        $js_path = Yii::getAlias('@root').'/'.$this->jsPath;
        if (!file_exists($js_path)) {
			$handle = fopen($js_path, 'w') or die('Cannot open file: '.$js_path);
		} else {
			$handle = fopen($js_path, 'r') or die('Cannot open file: '.$js_path);
			if (filesize($js_path))
				$this->data = fread($handle, filesize($js_path));
		}
		fclose($handle);
    }

	public function save()
	{
        $js_path = Yii::getAlias('@root').'/'.$this->jsPath;
		$handle = fopen($js_path, 'w+') or die('Cannot open file: '.$js_path);
		ftruncate($handle, 0);
		fwrite($handle, $this->data);
		fclose($handle);
	}
}
