<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Đổi mật khẩu';
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="user-create">

  <?php if (Yii::$app->session->hasFlash('success')): ?>
      <div class="alert alert-success alert-dismissable">
           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
           <h4><i class="icon fa fa-check"></i>Saved!</h4>
           <?= Yii::$app->session->getFlash('success') ?>
      </div>
  <?php endif; ?>

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="user-form">
        <div class="row row-wrapper">
            <div class="col-md-8">

              <?=$form->errorSummary($model); ?>

                <div class="white_bg">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-6"><?= $form->field($model, 'old_password')->textInput(['maxlength' => true]); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6"><?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6"><?= $form->field($model, 'retype_password')->passwordInput(['maxlength' => true]); ?></div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <div class="text-right">
            <?= Html::submitButton('<i class="far fa-save"></i> Lưu lại', ['class' => 'btn btn-info rounded-sm']) ?>
        </div>
    </div>
  <?php ActiveForm::end(); ?>

</div>
