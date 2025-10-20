<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Language;
use backend\models\Tab;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="link-form">
    <div class="row row-wrapper">
        <div class="col-md-8">

            <div class="white_bg">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'code')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'name')->textarea(['rows' => 6]) ?></div>
                    </div>

                    <div class="row">
                      <div class="col-12"><?= $form->field($model, 'ord')->textInput(['maxlength' => true]); ?></div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'type')->dropDownList(Tab::getType(), []) ?>
                        </div>

                        <div class="col-4">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="white_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">

                    <!-- Begin tải ảnh đại diện -->
                     <strong class="title_box">Ảnh đại diện</strong>
                     <div class="row">
                         <div class="col-12">
                            <div class="temp_img">
                               <img src="<?=(($model->path) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->path) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?=$model->name; ?>" />
                               <?= $form->field($model, 'file')->fileInput()->label(false); ?>
                               <?= $form->field($model, 'path')->hiddenInput()->label(false); ?>
                            </div>
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
$this->registerJs(
    "
    $('#tab-type').change(function() {
        let val = $(this).val();

        if (val == '2') {
            $('.vina-right').show();
        }
        else
        {
          $('.vina-right').hide();
        }
    });
    $('#tab-type').trigger('change');",
    yii\web\View::POS_READY,
    'my-tab-handler'
);
