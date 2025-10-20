<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Partner;
use backend\models\Language;
$filter_position = Partner::getPosition();
/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="partner-form">
    <div class="row row-wrapper">
        <div class="col-md-8">
            <div class="white_bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-8"><?= $form->field($model, 'url')->textInput(['maxlength' => true]); ?></div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'position')->dropDownList($filter_position, [
                                'prompt' => 'Vui lòng chọn...'
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'content')->textArea(['rows' => 5,'class' => 'ckeditor']); ?></div>
                    </div>
                    <div class="row info-row">
                        <div class="col-12"><?= $form->field($model, 'info')->textInput(['maxlength' => true]); ?></div>
                    </div>
                    <div class="row info-row1">
                        <div class="col-12"><?= $form->field($model, 'info2')->textInput(['maxlength' => true]); ?></div>
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
                    <div class="row line line_ddl">
                        <div class="col-md-5">
                            <?= $form->field($model, 'ord')->textInput() ?>
                        </div>
                    </div>
                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL(Yii::$app->language)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="white_bg vina-right" style="padding-bottom: 0; ">
                <div class="container-fluid">
                    <!-- Begin tải ảnh đại diện -->
                     <strong class="title_box">Ảnh đại diện</strong>
                     <div class="row">
                         <div class="col-12">
                            <div class="temp_img">
                               <img src="<?=(($model->path) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->path) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?= strip_tags($model->name); ?>" />
                               <?= $form->field($model, 'file')->fileInput()->label(false); ?>
                               <?= $form->field($model, 'path')->hiddenInput()->label(false); ?>
                            </div>
                         </div>
                     </div>
                </div>
            </div>
            <div class="white_bg vina-right img-hover" style="display: none">
                <div class="container-fluid">
                    <!-- Begin tải ảnh đại diện -->
                     <strong class="title_box">Ảnh 2</strong>
                     <div class="row">
                         <div class="col-12">
                            <div class="temp_img">
                               <img src="<?=(($model->background) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->background) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?= strip_tags($model->name); ?>" />
                               <?= $form->field($model, 'img')->fileInput()->label(false); ?>
                               <?= $form->field($model, 'background')->hiddenInput()->label(false); ?>
                            </div>
                         </div>
                     </div>
                </div>
            </div>
            <div class=" white_bg vina-right doc-box"  style="display: none">
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
$this->registerJs(
    "
    $('#partner-position').change(function() {
        let val = $(this).val();
        if (val == '111'  || val == '3'|| val == '4'|| val == '71') {
            $('.info-row1').show();
        }
        else
        {
          $('.info-row1').hide();
        }
        if (val == '3' || val == '44' || val == '111') {
            $('.info-row').show();
        }
        else
        {
          $('.info-row').hide();
        }
         if (val == '3' || val == '4' || val == '80') {
             $('.img-hover').show();
         }
         else
         {
           $('.img-hover').hide();
         }
        if (val == '1'  || val == '2') {
            $('.doc-box').show();
        }
        else
        {
          $('.doc-box').hide();
        }
    });
    $('#partner-position').trigger('change');",
    yii\web\View::POS_READY,
    'my-position-handler'
);
$this->registerJsFile("@web/ckeditor/ckeditor.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
$this->registerJs('CKEDITOR.replace( "ckbasic", { customConfig: "'.Yii::$app->urlManager->baseUrl.'/ckeditor/config_basic.js" } );', \yii\web\View::POS_END);
?>