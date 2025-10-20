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
class UpdateCss extends Model
{
    public $cssPath = 'bundle/css/customize.css';
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
        $css_path = Yii::getAlias('@root').'/'.$this->cssPath;
        if (!file_exists($css_path)) {
			$handle = fopen($css_path, 'w') or die('Cannot open file: '.$css_path);
		} else {
			$handle = fopen($css_path, 'r') or die('Cannot open file: '.$css_path);
			if (filesize($css_path))
				$this->data = fread($handle, filesize($css_path));
		}
		fclose($handle);
    }

	public function save()
	{
        $css_path = Yii::getAlias('@root').'/'.$this->cssPath;
		$handle = fopen($css_path, 'w+') or die('Cannot open file: '.$css_path);
		ftruncate($handle, 0);
		fwrite($handle, $this->data);
		fclose($handle);
	}
}
