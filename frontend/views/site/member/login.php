<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'login');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['site/login']];

?>

<div class="wrapper">
  <div class="member-page">

    <div class="container">

      <div class="member-form signup-form">
        <h1 class="title"><?= Html::encode($this->title) ?></h1>

        <div class="box-form">

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

              <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

              <?= $form->field($model, 'password')->passwordInput() ?>

              <?= $form->field($model, 'rememberMe')->checkbox() ?>

              <div class="info-text">
                <?= Yii::t('app', 'member-reset-password', [
                  'link' => Url::toRoute('site/request-password-reset')
                ])
                ?>
                <br>
                <?= Yii::t('app', 'member-veri-new', [
                  'link' => Url::toRoute('site/request-verification-email')
                ])
                ?>
              </div>

              <div class="form-group text-center">
                  <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
              </div>

            <?php ActiveForm::end(); ?>
        </div>

      </div>
    </div>
  </div>
</div>
