<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Cat;
use backend\models\Brand;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
        <div class="row">
            <div class="col-6 col-md-2 offset-md-8"><?= $form->field($model, 'cat_id')->dropDownList(Cat::getCatDDL(), ['prompt' => 'Chọn danh mục...'])->label(false); ?></div>
<!--            <div class="col-6 col-md-2">--><?//= $form->field($model, 'brand_id')->dropDownList(Brand::getBrandDDL(), ['prompt' => 'Chọn thương hiệu...'])->label(false); ?><!--</div>-->
<!--            <div class="col-6 col-md-2">--><?//= $form->field($model, 'status')->dropDownList(Yii::$app->params['status'], ['prompt' => 'Chọn trạng thái...'])->label(false); ?><!--</div>-->
            <div class="col-6 col-md-2 form-group">
                <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary', 'style' => 'width: 100%; line-height: 32px; height: 32px; padding: 0 5px;']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <hr style="margin-top: 5px; margin-bottom: 10px;">

</div>
