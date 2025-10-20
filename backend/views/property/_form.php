<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="property-form">
    <div class="row row-wrapper">
        <div class="col-md-7">

            <div class="white_bg">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-md-3">
                            <?= $form->field($model, 'ord')->textInput(['maxlength' => true]); ?>
                        </div>

                        <div class="col-6 col-md-3">
                            <div style="margin-top: 30px;">
                                <?= $form->field($model, 'active')->checkBox() ?>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div style="margin-top: 30px;">
                                <?= $form->field($model, 'has_image')->checkBox() ?>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
                        </div>


                    </div>

                </div>
            </div>

        </div>


        <div class="col-md-5">
            <div class="white_bg">

                <!-- Begin property box -->
                <div class="container-fluid" id="container_vprop">
                    <div class="row" id="form_vprop">
                        <div class="col-8 col-md-9">
                            <input type="text" name="" value="" placeholder="Giá trị thông số..." class="form-control rounded">
                        </div>
                        <div class="col-4 col-md-3">
                            <button type="button" class="create_btn btn btn-primary" name="button"><i class="fas fa-plus"></i> Thêm</button>
                            <button type="button" class="update_btn btn btn-primary" name="button"><i class="fas fa-download"></i> Lưu</button>
                        </div>
                    </div>
                    <ul id="list_vprop"></ul>
                    <?= $form->field($model, 'json_values')->hiddenInput()->label(false); ?>
                </div>
                <!-- End property box -->

            </div>
        </div>


    </div>

    <div class="text-right">
        <?= Html::submitButton('<i class="far fa-save"></i> Lưu lại', ['class' => 'btn btn-info rounded-sm']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
