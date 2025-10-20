<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['site/member-change-password']];

?>

<div class="wrapper">

  <div class="container">
    <div class="row">
      <div class="col-12 col-md-8">

        <div class="account-page">
          <div class="member-form">
            <h1 class="title"><?= Html::encode($this->title) ?></h1>

            <div class="box-form">
              <?php if (Yii::$app->session->hasFlash('update')): ?>
                <div class="alert alert-success" role="alert">
                  <?= Yii::$app->session->getFlash('update'); ?>
                </div>
              <?php endif; ?>

              <?php $form = ActiveForm::begin(['id' => 'member-info-form']); ?>


                <?= $form->field($model, 'old_password')->passwordInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'old_password')]) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'phone')]) ?>
                <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => Yii::t('app', 'password-confirm')]) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton(Yii::t('app', 'save'), ['class' => 'btn btn-primary']) ?>
                </div>
              <?php ActiveForm::end(); ?>
            </div>

          </div>
        </div>
      </div>

      <div class="col-12 col-md-4">
        <?= Yii::$app->controller->renderPartial('member/sidebar'); ?>
      </div>


    </div>
  </div>
</div>
