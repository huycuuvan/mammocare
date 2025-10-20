<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Language;
use backend\models\Province;
use backend\models\CatProfile;
use backend\models\Profile;

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
                    <h2 class="tab_sperate">Thông tin cơ bản</h2>
                    <div class="row pd10">


                        <div class="col-12 col-md-6">
                            <?= $form->field($model, 'name')->textInput(['placeholder' => 'Họ tên']) ?>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <?= $form->field($model, 'desired_job_id',['options' => ['id' => 'form-group']])->dropDownList(CatProfile::getAllCatProfileDDL(),['class' => 'mulselect_cat','prompt' => 'Vui lòng chọn...']) ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?= $form->field($model, 'title')->textInput() ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?= $form->field($model, 'address')->textInput(['placeholder' => 'Địa chỉ']) ?>
                        </div>

                        <div class="col-12 col-md-6">
                            <?= $form->field($model, 'birthday', ['options' => ['class' => 'form-group','id'=>'datepicker']])->textInput() ?>
                        </div>
                        <div class="col-12">
                            <?= $form->field($model, 'self_description')->textarea(['rows'=>5]); ?>
                        </div>


                    </div>

                    <h2 class="tab_sperate">Quá trình công tác</h2>
                    <div class="row pd10">
                        <div class="col-12 ">
                            <?= $form->field($model, 'course')->textInput(); ?>
                        </div>
                        <div class="col-12">
                            <?= $form->field($model, 'objective')->textInput(); ?>
                        </div>
                        <div class="col-12 ">
                            <?= $form->field($model, 'graduated_year')->textInput(); ?>
                        </div>
                        <div class="col-12 ">
                            <?= $form->field($model, 'height')->textInput(); ?>
                        </div>
                        <div class="col-12 ">
                            <?= $form->field($model, 'weight')->textInput(); ?>
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

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL(Yii::$app->language)); ?>
                        </div>
                    </div>

                </div>
            </div>

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
<!--                              <a href="#">Xóa</a>-->
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
