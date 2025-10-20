<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Language;
use backend\models\Supporter;
use backend\models\CatDoctor;
$filter_position = Supporter::getPosition();

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
                        <div class="col-12">
<!--                            --><?//= $form->field($model, 'job')->textInput(['maxlength' => true]); ?>
                            <?= $form->field($model, 'job')->dropDownList(CatDoctor::getParentDDL(), ['prompt' => 'Vui lòng chọn...']); ?>
                        </div>

                        <div class="col-12"><?= $form->field($model, 'brief')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'content')->textarea(['maxlength' => true, 'rows' => 5]); ?></div>
                    </div>

                    <div class="row">

                         <div class="col-md-6"><?= $form->field($model, 'mobile')->textInput(['maxlength' => true]); ?></div>
                         <div class="col-md-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'info1')->textArea(['rows' => 5, 'id' => 'ckbasic1']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'info2')->textArea(['rows' => 5, 'id' => 'ckbasic2']); ?>
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
                            <?= $form->field($model, 'home')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line line_ddl">
                        <div class="col-md-5">
                            <?= $form->field($model, 'ord')->textInput() ?>
                        </div>
                    </div>

                    <div class="row line line_ddl">
                        <div class="col-12">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class=" white_bg vina-right" style="padding-bottom: 0;">
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
$this->registerJsFile("@web/ckeditor/ckeditor.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
$this->registerJs('CKEDITOR.replace( "ckbasic1", { customConfig: "'.Yii::$app->urlManager->baseUrl.'/ckeditor/config_basic.js" } );', \yii\web\View::POS_END);
$this->registerJs('CKEDITOR.replace( "ckbasic2", { customConfig: "'.Yii::$app->urlManager->baseUrl.'/ckeditor/config_basic.js" } );', \yii\web\View::POS_END);
?>