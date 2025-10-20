<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Menu;
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

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"><?= $form->field($model, 'type')->dropDownList(Menu::getMenuDLL(), [
                            'prompt' => 'Vui lòng chọn...',
                            'id' => 'list_types'
                        ]); ?></div>

                        <div class="col-md-4"><?= $form->field($model, 'parent')->dropDownList(Menu::getParentDDL($model->position), ['prompt' => 'Vui lòng chọn...']); ?></div>

                    </div>

                    <div class="row" id="link_website" style="<?php echo (empty($model->type) || $model->type!="0:0")?"display: none":""; ?>">
                        <div class="col-12"><?= $form->field($model, 'link')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <script type="text/javascript">
              				$(function() {

              					//click radio
              					$('#list_types').each(function() {
              						$(this).change(function() {
              							val_ddl = $(this).val();
              							ele = $("#link_website");
              							dis_val = ele.css("display");
              							if (val_ddl == "0:0")
              							{
              								if (dis_val != "block")
              									ele.show();
              							}
              							else
              							{
              								if (dis_val != "none")
              									ele.hide();
              							}
              						});
              					});

              				});
              			</script>
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'description')->textInput([]); ?>
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
                            <?= $form->field($model, 'ord')->textInput() ?>
                        </div>
                    </div>
                    <div class="row line d-none">
                        <div class="col-12">
                            <?= $form->field($model, 'full')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'new_tab')->checkBox() ?>
                            <?= $form->field($model, 'position')->hiddenInput()->label(false); ?>
                        </div>
                    </div>

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="white_bg vina-right " style="padding-bottom: 0;">
                <div class="container-fluid">

                    <!-- Begin tải ảnh đại diện -->
                    <strong class="title_box">Ảnh đại diện</strong>
                    <div class="row">
                        <div class="col-12">
                            <div class="temp_img">
                                <img src="<?=(($model->background) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->background) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" alt="<?=$model->name; ?>" />
                                <?= $form->field($model, 'img')->fileInput()->label(false); ?>
                                <?= $form->field($model, 'background')->hiddenInput()->label(false); ?>
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
