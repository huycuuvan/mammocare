<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\CatNews;
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

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'parent')->dropDownList(CatNews::getCatNewsDDL(), [
                                'prompt' => 'Vui lòng chọn...'
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'position')->dropDownList(CatNews::getPosition(), [
                                'prompt' => 'Vui lòng chọn...'
                            ]); ?>
                        </div>
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
                                  $base_url = $_SERVER['SERVER_NAME'].Yii::$app->urlManagerFrontend->createUrl(['site/list-news', 'id' => $model->id, 'name' => $model->url, 'page'=>1]);
                                    ?>
                                    <h3><?=($model->seo_title) ? $model->seo_title : $model->name; ?></h3>
                                    <a href="http://<?=$base_url; ?>" target="_blank">https://<?= $base_url; ?></a>
                                    <p><?=($model->seo_desc) ? $model->seo_desc : $model->name; ?></p>
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
                            <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'seo_desc')->textarea(['rows' => 3]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'url')->textInput(['maxlength' => true, 'autocomplete' => 'off']); ?></div>
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
                    <div class="row line">
                        <div class="col-12">
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
