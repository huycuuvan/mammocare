<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\CatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'left_menu') ?>

    <?php // echo $form->field($model, 'right_menu') ?>

    <?php // echo $form->field($model, 'ord') ?>

    <?php // echo $form->field($model, 'home') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'parent') ?>

    <?php // echo $form->field($model, 'seo_title') ?>

    <?php // echo $form->field($model, 'seo_desc') ?>

    <?php // echo $form->field($model, 'seo_keyword') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
