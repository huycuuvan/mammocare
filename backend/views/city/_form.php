<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\City;
use backend\models\Language;


/* @var $this yii\web\View */
/* @var $model backend\models\Cat */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="cat-news-form">
    <div class="row row-wrapper">
        <div class="col-md-8">

            <div class="white_bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?></div>
                    </div>


                    <div class="row d-none">
                      <div class="col-md-6"><?= $form->field($model, 'latitude')->textInput(['maxlength' => true]); ?></div>
                      <div class="col-md-6"><?= $form->field($model, 'longitude')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 d-none">
                            <?= $form->field($model, 'parent')->dropDownList(City::getCityDDL(), [
                                'prompt' => 'Vui lòng chọn...'
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'position')->dropDownList(City::getPosition(), [
                                'prompt' => 'Vui lòng chọn...'
                            ]); ?>
                        </div>

                    </div>

                    <div class="row">
                      <div class="col-6 d-none"><?= $form->field($model, 'zoom')->textInput(['maxlength' => true]); ?></div>
                      <div class="col-6"><?= $form->field($model, 'ord')->textInput(['maxlength' => true]); ?></div>
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
                            <?= $form->field($model, 'home')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'active')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line line_ddl">
                        <div class="col-12">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
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
