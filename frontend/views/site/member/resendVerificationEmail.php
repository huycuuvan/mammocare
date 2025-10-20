<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('app', 'member-verification-request');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['site/request-verification-email']];
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
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
              <p><?= Yii::t('app', 'member-verification-email-prompt') ?></p>

              <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'email')]) ?>

              <div class="form-group text-center">
                  <?= Html::submitButton(Yii::t('app', 'send'), ['class' => 'btn btn-primary']) ?>
              </div>
            <?php ActiveForm::end(); ?>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>
