<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Seo;
use backend\components\MyExt;
use backend\models\Language;

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

                    <?php
                    if (!$model->isNewRecord) {
                        ?>
                        <h2 class="tab_sperate row no-gutters">
                            <div class="col-md-6">Thông tin SEO trang <?=Seo::getPageDDL()[$model->type]; ?></div>
                        </h2>

                        <div class="row">
                            <div class="col-12">
                                <div class="format_seo" style="padding: 15px; border: 1px dashed #ddd;">
<!--                                    --><?php //$base_url = MyExt::getDomain().Seo::getUrls($model->type); ?>
<!--                                    --><?php //$base_url = MyExt::getDomain().Seo::getUrl()[$model->type]; ?>
                                    <h3><?=$model->site_title; ?></h3>
<!--                                    <a href="--><?//=$base_url; ?><!--" target="_blank">--><?//= $base_url; ?><!--</a>-->
                                    <p><?=$model->site_desc; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'type')->dropDownList(Seo::getPageDDL(), ['prompt' => 'Vui lòng chọn...']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'site_title')->textInput(['maxlength' => 70, 'show-maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'site_desc')->textarea(['rows' => 5, 'maxlength' => 320, 'show-maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'site_keyword')->textarea(['rows' => 6]) ?></div>
                    </div>

                </div>
            </div>

        </div>


        <div class="col-md-4">

            <div class="white_bg gray_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">

                    <div class="row line line_ddl">
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
                               <img src="<?=(($model->path) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->path) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?=$model->site_title; ?>" />
                               <?= $form->field($model, 'file')->fileInput()->label(false); ?>
                               <?= $form->field($model, 'path')->hiddenInput()->label(false); ?>
                               <a href="#">Xóa</a>
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
