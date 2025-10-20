<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\CatApp;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="news-form">
    <div class="row row-wrapper">
        <div class="col-lg-8">

            <div class="white_bg">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'brief')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                           <?= $form->field($model, 'content', ['enableClientValidation' => false])->textArea(['maxlength' => true,'class' => 'ckeditor']); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'cat_id')->dropDownList(CatApp::getAllCatAppDDL(), ['prompt' => 'Vui lòng chọn...']); ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'hits')->textInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'list')->textInput(['maxlength' => true]); ?></div>
                    </div>
                </div>
            </div>

            <div class="white_bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6"><strong class="title_box">Tối ưu SEO</strong></div>
                        <div class="col-6 text-right">
                            <a data-toggle="collapse" href="#collapse_seobox" role="button" aria-expanded="false" aria-controls="collapse_seobox">Chỉnh sửa SEO</a>
                        </div>
                        <div class="col-12">
                            <div class="format_seo">
                              <?php
                              if ($model->isNewRecord) {
                                  ?><p>Thiết lập các thẻ mô tả giúp khách hàng dễ dàng tìm thấy danh mục này trên công cụ tìm kiếm như Google.</p><?php
                              } else {
                                $base_url = $_SERVER['SERVER_NAME'].Yii::$app->urlManagerFrontend->createUrl(['site/news', 'cat' => $model->father->url, 'id' => $model->id, 'name' => $model->url]);
                                  ?>
                                  <h3><?=($model->seo_title) ? $model->seo_title : $model->title; ?></h3>
                                  <a href="http://<?=$base_url; ?>" target="_blank">https://<?= $base_url; ?></a>
                                  <p><?=($model->seo_desc) ? $model->seo_desc : strip_tags($model->brief); ?></p>
                                  <?php
                              };
                              ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid collapse" id="collapse_seobox">
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'seo_title')->textInput(['maxlength' => 70, 'show-maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'seo_desc')->textarea(['rows' => 5, 'maxlength' => 320, 'show-maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'url')->textInput(['maxlength' => true, 'autocomplete' => 'off']); ?></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="white_bg gray_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">
                    <strong class="title_box">Hiển thị</strong>

<!--                    <div class="row line">-->
<!--                        <div class="col-12">-->
<!--                            --><?//= $form->field($model, 'hot')->checkBox() ?>
<!--                        </div>-->
<!--                    </div>-->

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
                        <div class="col-md-5">
                            <?= $form->field($model, 'ord')->textInput() ?>
                        </div>
                    </div>
                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
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
                              <img src="<?=(($model->path) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->path) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?=$model->title; ?>" />
                              <?= $form->field($model, 'file')->fileInput()->label(false); ?>
                              <?= $form->field($model, 'path')->hiddenInput()->label(false); ?>
<!--                              <a href="#">Xóa</a>-->
                           </div>
                        </div>
                    </div>
                    
                    <!-- Begin tải ảnh đại diện -->
<!--                    <strong class="title_box">Tags tìm kiếm</strong>-->
<!--                    <div class="row">-->
<!--                        <div class="col-12">-->
<!--                           --><?//= $form->field($model, 'tags')->hiddenInput(['maxlength' => true, 'placeholder' => 'Vd: Samsung, Vinfast, Apple,...', 'data-role' => 'tagsinput'])->label(false); ?>
<!--                        </div>-->
<!--                    </div>-->

                </div>
            </div>
            <div class="white_bg vina-right" >
                <div class="container-fluid">

                    <!-- Begin tải ảnh đại diện -->
                    <strong class="title_box">Ảnh Mobile</strong>
                    <div class="row">
                        <div class="col-12">
                            <div class="temp_img">
                                <img src="<?=(($model->background) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->background) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?= strip_tags($model->title); ?>" />
                                <?= $form->field($model, 'img')->fileInput()->label(false); ?>
                                <?= $form->field($model, 'background')->hiddenInput()->label(false); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-none white_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">

                  <strong class="title_box">Tệp tin đính kèm</strong>
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
$this->registerJs('CKEDITOR.replace( "ckbasic", { customConfig: "'.Yii::$app->urlManager->baseUrl.'/ckeditor/config_basic.js" } );', \yii\web\View::POS_END);
?>
