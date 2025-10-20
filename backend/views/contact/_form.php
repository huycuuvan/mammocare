<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="contact-form">
    <div class="row row-wrapper">
        <div class="col-md-8">

            <div class="white_bg">
                <div class="container-fluid">
                    <?=$form->errorSummary($model); ?>
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?></div>
                    </div>


                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'address')->textArea(['maxlength' => true]) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'address2')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'slogan')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-4"><?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-md-4"><?= $form->field($model, 'hotline')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-md-4"><?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-md-4"><?= $form->field($model, 'hotline2')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-md-4"><?= $form->field($model, 'email_bcc')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"><?= $form->field($model, 'hotline3')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-md-6"><?= $form->field($model, 'map')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <?php
                    if (!$model->isNewRecord) {
                        ?>
                        <div style="margin: 10px 0 20px 0;">
                            <a style="font-weight: 600; font-size: 15px;" href="<?=Url::to(["contact/office", "id" => $model->id]); ?>"><i class="fas fa-map-marker-alt"></i> Thêm chi nhánh & văn phòng công ty</a>
                        </div>
                        <?php
                    }
                    ?>

                   <h2 class="tab_sperate">Thông tin Seo trang chủ</h2>

                   <div class="row">
                       <div class="col-12"><?= $form->field($model, 'site_title')->textInput(['maxlength' => true]) ?></div>
                   </div>

                   <div class="row">
                       <div class="col-12">
                        <?= $form->field($model, 'site_desc')->textarea(['rows' => 6]) ?>
                       </div>
                   </div>

                   

                    <h2 class="tab_sperate">Thông tin cuối trang</h2>
                    <div class="row">
                    
                       <div class="col-12 d-none">
                          <?= $form->field($model, 'footer')->textarea(['maxlength' => true,'class' => 'ckeditor']) ?>
                       </div>
                        <div class="col-12"><?= $form->field($model, 'copyright')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <h2 class="tab_sperate d-none">Cấu hình tiền tệ</h2>

                    <div class="row d-none">
                        <div class="col-6"><?= $form->field($model, 'currency_format')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6"><?= $form->field($model, 'replace_price')->textInput(['maxlength' => true]) ?></div>
                    </div>



                    <h2 class="tab_sperate ">Trang nội dung</h2>

<!---->
<!--                    <div class="row">-->
<!--                        <div class="col-12">-->
<!--                            --><?//= $form->field($model, 'about_content')->textarea(['maxlength' => true,'class' => 'ckeditor']) ?>
<!--                        </div>-->
<!--                    </div>-->
                    <div class="row  ">
                        <div class="col-12">
                            <?= $form->field($model, 'about_title')->textarea(['maxlength' => true,'class' => 'ckeditor']) ?>
                        </div>
                    </div>
                    <div class="row  ">
                        <div class="col-12">
                            <?= $form->field($model, 'about_url')->textarea(['maxlength' => true,'class' => 'ckeditor']) ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="white_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">

                    <!-- Begin tải ảnh đại diện -->
                    <strong class="title_box">Logo</strong>
                    <div class="row">
                        <div class="col-12">
                           <div class="temp_img">
                              <img style="max-width: 35%;" src="<?=(($model->logo) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->logo) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?=$model->company_name; ?>" />
                              <?= $form->field($model, 'img')->fileInput()->label(false); ?>
                              <?= $form->field($model, 'logo')->hiddenInput()->label(false); ?>
                              <a href="#">Xóa</a>
                           </div>
                        </div>
                    </div>

                    <!-- Begin tải ảnh đại diện -->
                    <strong class="title_box">Logo mobile</strong>
                    <div class="row">
                        <div class="col-12">
                            <div class="temp_img">
                                <img style="max-width: 35%;" src="<?=(($model->logo_mobile) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->logo_mobile) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?=$model->company_name; ?>" />
                                <?= $form->field($model, 'img_mobile')->fileInput()->label(false); ?>
                                <?= $form->field($model, 'logo_mobile')->hiddenInput()->label(false); ?>
                                <a href="#">Xóa</a>
                            </div>
                        </div>
                    </div>
<!--                     Begin tải ảnh đại diện -->
                    <strong class="title_box">Logo Footer</strong>
                    <div class="row">
                        <div class="col-12">
                           <div class="temp_img">
                              <img style="max-width: 35%;" src="<?=(($model->logo_footer) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->logo_footer) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?=$model->company_name; ?>" />
                              <?= $form->field($model, 'img_footer')->fileInput()->label(false); ?>
                              <?= $form->field($model, 'logo_footer')->hiddenInput()->label(false); ?>
                              <a href="#">Xóa</a>
                           </div>
                        </div>
                    </div>


                    <div class="white_bg vina-right" style="padding-bottom: 0;">
                        <div class="container-fluid">

                        <strong class="title_box">Video</strong>
                        <div class="row">
                            <div class="col-12">
                                <?php if(!empty($model->path_file)): ?>
                                <p><a href="<?= Yii::$app->urlManagerFrontend->baseUrl.'/'. $model->path_file ?>" target="_blank"><?= $model->path_file ?></a></p>
                                <?= $form->field($model, 'del_doc')->checkbox(); ?>
                                <?php endif; ?>

                                <?= $form->field($model, 'doc')->fileInput()->label(false); ?>
                                <?= $form->field($model, 'path_file')->hiddenInput()->label(false); ?>

                            </div>
                        </div>

                        </div>
                    </div>
                    
                    <div class="row line">
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
<?php
$this->registerJsFile("@web/ckeditor/ckeditor.js", [
   'depends' => [\backend\assets\AppAsset::className()],
   'position' => \yii\web\View::POS_HEAD
]);
?>
