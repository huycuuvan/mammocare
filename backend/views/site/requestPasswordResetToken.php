<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập quản trị hệ thống website';
?>
<div class="login_admin">
    <div class="wrapper-login">
        <p class="text-center"><a href="http://vinaweb.vn" target="_blank"><img height="50" src="images/logo-vinaweb.png" alt="vinaweb"></a></p>
        <div class="site-login">
            <p class="text-center">Quên mật khẩu</p>
            <div class="row">
                <div class="col-12">
                    <?php
                    if (Yii::$app->session->hasFlash('success')) {
                        echo '<p style="font-weight: bold">'.Yii::$app->session->getFlash('success').'<p>';
                    } else {
                        if (Yii::$app->session->hasFlash('error')) {
                            echo '<p>'.Yii::$app->session->getFlash('error').'<p>';
                        }
                        $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                            <?= $form->field($model, 'email')->textInput([
                                    'placeholder' => 'Nhập email tài khoản của bạn',
                                    'autofocus' => true
                                ])->label(false); ?>
                            <p class="text-center"><?= Html::submitButton('Gửi email thay đổi mật khẩu', ['class' => 'btn btn-primary', 'name' => 'login-button']); ?></p>
                        <?php ActiveForm::end();
                    }
                    ?>

                    <div class="support_box">
                        <p>Cảm ơn bạn đã tin tưởng và lựa chọn Vinaweb!</p>
                        <p>Chúng tôi sẽ nỗ lực hết mình để mang đến những trải nghiệm tốt nhất và giúp việc kinh doanh của bạn thành công.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
