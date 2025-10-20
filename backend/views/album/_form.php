<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\Picture;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="album-form">
    <div class="row row-wrapper">
        <div class="col-md-8">

            <div class="white_bg">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-4 thumb_album">
                            <?= $form->field($model, 'path')->hiddenInput(['label' => 'Chọn ảnh đại diện']) ?>
                            <a><img src="<?= (!empty($model->path))?(Yii::$app->urlManagerFrontend->baseUrl."/".$model->path):'images/choose_img.jpg'; ?>" alt=""></a>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-12">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
                                    <?php $timestamp = time(); ?>
                                    <?php echo $form->field($model, 'pid', ['template' => '{input}'])->hiddenInput(['value'=> (($model->id)?$model->id:$timestamp)])->label(false); ?>
                                </div>
                                <div class="col-12"><?= $form->field($model, 'brief')->textarea(['rows' => 6]) ?></div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <p class="text-right">
                        <!-- Begin nút thêm ảnh -->
                        <a href="javascript:void(0)" class="fileinput-button" style="display: inline-block; line-height: 20px;">+ Thêm ảnh mới
                            <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload" type="file" name="files[]" data-url="<?=Url::to(['picture/upload']); ?>" data-form-data='{"pid": <?=($model->id)?$model->id:$timestamp; ?>}' multiple>
                        </a>
                        <!-- End nút thêm ảnh -->
                    </p>

                    <div id="progress" class="rounded" style="opacity: 0;">
                        <div class="bar" style="width: 0%;"></div>
                    </div>

                    <ul id="imgs_by_album">
                        <?php
                        if (!empty($model->imgs)) {
                            $imgs = $model->getImgs()->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->all();
                            foreach ($imgs as $row) {
                                ?>
                                <li data-id="<?=$row->id; ?>">
                                    <img src="<?=Yii::$app->urlManagerFrontend->baseUrl."/".$row->path; ?>" title="<?= $row->alt; ?>" alt="<?=$row->path; ?>">
                                    <a class="del_tag" href="#">×</a>
                                    <a class="edit_tag" href="#">Alt</a>
                                    <a class="video_tag" href="#"><i class="fab fa-youtube-square"></i></a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>

                    <div class="clearfix"></div>

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
                                    $base_url = $_SERVER['SERVER_NAME'].Yii::$app->urlManagerFrontend->createUrl(['site/album', 'id' => $model->id, 'name' => $model->url]);
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
                        <div class="col-5">
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

        </div>

    </div>

    <div class="text-right">
        <?= Html::submitButton('<i class="far fa-save"></i> Lưu lại', ['class' => 'btn btn-info rounded-sm', 'onclick' => 'putImageInAlbum()']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>

<!-- Modal -->
<div class="modal fade my_modal" id="edit_name_img" tabindex="-1" role="dialog" aria-labelledby="edit_name_img_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="edit_name_img_title">Cập nhật mô tả ảnh</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body form-group">
                <input id="edit_title_placeholder" type="text" data-id="" class="form-control">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Cập nhật</button>
            </div>

        </div>
    </div>
</div>


<?php
$this->registerCssFile("@web/jupload/css/jquery.fileupload.css", [
    'depends' => [\backend\assets\AppAsset::className()]
]);
//The jQuery UI widget factory, can be omitted if jQuery UI is already included
$this->registerJsFile("@web/jupload/js/vendor/jquery.ui.widget.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
//The Iframe Transport is required for browsers without support for XHR file uploads
$this->registerJsFile("@web/jupload/js/jquery.iframe-transport.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
//The basic File Upload plugin
$this->registerJsFile("@web/jupload/js/jquery.fileupload.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
$this->registerJsFile("@web/jupload/js/album.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
?>
<div class="modal fade" id="add-youtube-code" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Thêm mã Youtube</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input class="form-control" data-id="" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="change-code">Lưu lại</button>
            </div>
        </div>
    </div>
</div>