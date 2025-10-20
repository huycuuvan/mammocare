<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'signup');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['site/signup']];
?>
<div class="wrapper">
  <div class="member-page">
    <div class="container">

      <div class="member-form signup-form">
        <h1 class="title"><?= Html::encode($this->title) ?></h1>

        <div class="box-form">
          <?php if (Yii::$app->session->hasFlash('signup')): ?>
          <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('signup'); ?>
          </div>

          <div class="back-home">
            <a href="<?= Url::home(true) ?>" class="btn"><?= Yii::t('app', 'back-home') ?></a>
          </div>
          <?php else: ?>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <p><?= Yii::t('app', 'member-signup-desc') ?></p>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => Yii::t('app', 'username')]) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'email')]) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'password')]) ?>

            <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => Yii::t('app', 'password-confirm')]) ?>


            <div class="form-group text-center">
              <?= Html::submitButton(Yii::t('app', 'signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>
