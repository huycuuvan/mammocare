<?php
namespace backend\components;

use yii\base\Action;

class UpdateAjaxAction extends Action
{
    public function run()
    {
    	$model = $this->controller->findModel(10);
        echo $model->title;
    }
}
?>