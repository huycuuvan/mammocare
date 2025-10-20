<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactCustomer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-form">
  <div class="row row-wrapper">
    <div class="col-md-8">

      <div class="white_bg">
          <div class="container-fluid">

          <?php $form = ActiveForm::begin(); ?>

          <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

          <?= $form->field($model, 'created_at')->textInput() ?>

          <div class="form-group">
              <?= Html::submitButton('<i class="far fa-save"></i> Lưu lại', ['class' => 'btn btn-info rounded-sm']) ?>
          </div>

          <?php ActiveForm::end(); ?>

          </div>
      </div>
    </div>
  </div>
</div>
