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
                        <div class="col-12 col-md-6">
                            <?= $form->field($model, 'p_from')->textInput(['maxlength' => true]); ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?= $form->field($model, 'p_to')->textInput(['maxlength' => true]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <?= $form->field($model, 'ord')->textInput(['maxlength' => true]); ?>
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
