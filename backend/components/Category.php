<?php
namespace backend\components;

use yii\base\Widget;
use yii\helpers\Html;

class Category extends Widget
{
    public $name = 'Danh mục';
    public $data;
    public $checkBox = ['active' => 'H.Thị'];
    public $actionUpdate;
    public $actionDelete;
    public $actionSort;
    public $moreLink = [];

    public function run()
    {
        return $this->render('category');
    }
}
