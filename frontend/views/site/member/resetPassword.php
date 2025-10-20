<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['site/request-password-reset']];
?>


<div class="wrapper">
  <div class="member-page">
    <div class="container">

      <div class="member-form reset-form">
        <h1 class="title"><?= Html::encode($this->title) ?></h1>

        <div class="box-form">
          <?php if (Yii::$app->session->hasFlash('reset')): ?>
            <div class="alert alert-success" role="alert">
              <?= Yii::$app->session->getFlash('reset'); ?>
            </div>

            <div class="back-home">
              <a href="<?= Url::home(true) ?>" class="btn"><?= Yii::t('app', 'back-home') ?></a>
            </div>
          <?php else: ?>
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
              <p><?= Yii::t('app', 'member-reset-new-pass') ?></p>

              <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'password')]) ?>
              <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => Yii::t('app', 'password-confirm')]) ?>

              <div class="form-group text-center">
                  <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-primary']) ?>
              </div>
            <?php ActiveForm::end(); ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>
