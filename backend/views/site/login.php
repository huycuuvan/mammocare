<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Đăng nhập quản trị hệ thống website';
?>
<div class="login_admin">
    <div class="wrapper-login">
        <p class="text-center"><a href="http://vinaweb.vn" target="_blank"><img height="50" src="images/logo-vinaweb.png" alt="vinaweb"></a></p>
        <div class="site-login">
            <p class="text-center">Đăng nhập hệ thống</p>
            <div class="row">
                <div class="col-12">
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation'=>false]); ?>
                        <?=$form->errorSummary($model); ?>
                        <?= $form->field($model, 'username', [
                            'template' => '{input}',
                            'options' => ['tag' => false]])->textInput(['placeholder' => 'Tên đăng nhập', 'autocomplete' => 'off'])->label(false); ?>

                        <?= $form->field($model, 'password', [
                            'template' => '{input}',
                            'options' => ['tag' => false]])->passwordInput(['placeholder' => 'Mật khẩu', 'autocomplete' => 'off'])->label(false); ?>
                        <div class="row no-gutters">
                            <div class="col-7 checkbox"><?= $form->field($model, 'rememberMe')->checkbox(); ?></div>
                            <div class="col-5 text-right">
                                <p style="line-height: 20px; padding: 5px 0;"><a href="<?=Url::to('site/request-password-reset'); ?>">Quên mật khẩu ?</a></p>
                            </div>
                        </div>
                        <p class="text-center"><?= Html::submitButton('Đăng Nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?></p>
                    <?php ActiveForm::end(); ?>

                    <div class="support_box">
                        <p>Cảm ơn bạn đã tin tưởng và lựa chọn Vinaweb!</p>
                        <p>Chúng tôi sẽ nỗ lực hết mình để mang đến những trải nghiệm tốt nhất và giúp việc kinh doanh của bạn thành công.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
