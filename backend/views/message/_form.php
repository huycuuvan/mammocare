<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Message;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="message-form">
    <div class="row row-wrapper">
        <div class="col-md-8">
        <?=$form->errorSummary($model); ?>

            <div class="white_bg">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-8"><?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?></div>
                        <div class="col-md-4">
                        	<?= $form->field($model, 'type_id')->dropDownList(Message::getType(), ['prompt' => 'Vui lòng chọn...']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'content', ['enableClientValidation' => false])->textArea(['maxlength' => true,'class' => 'ckeditor']); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="white_bg gray_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">
                    <strong class="title_box">Hiển thị</strong>

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'active')->checkBox() ?>
                        </div>
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
<?php
$this->registerJsFile("@web/ckeditor/ckeditor.js", [
   'depends' => [\backend\assets\AppAsset::className()],
   'position' => \yii\web\View::POS_HEAD
]);
?>
