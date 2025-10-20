<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Cat;
use backend\models\Brand;
use backend\models\CatNews;
use backend\models\Attachment;
use backend\models\Property;
use backend\models\PropertyValue;
use yii\helpers\Url;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="product-form">
    <div class="row row-wrapper">
        <div class="d-none base-path" data-base='<?= Yii::$app->params['basePath'] ?>'></div>

        <?php //var_dump($model->getErrors()); ?>

        <!-- Begin left -->
        <div class="col-md-8">
            <div class="white_bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?></div>
                        <?php $timestamp = time(); ?>
                        <?php echo $form->field($model, 'pid', ['template' => '{input}'])->hiddenInput(['value'=> (($model->id)?$model->id:$timestamp)])->label(false); ?>
                    </div>

                    <div class="row">

                        <div class="col-6 ">
                            <?= $form->field($model, 'sale')->textInput() ?>
                        </div>

                        <div class="col-6 ">
                            <?= $form->field($model, 'retail')->textInput() ?>
                        </div>
                    </div>

                    <div class="row d-none">
                        <div class="col-6 ">
                            <?= $form->field($model, 'description4')->textInput() ?>
                        </div>

                        <div class="col-6 ">
                            <?= $form->field($model, 'description5')->textInput() ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'code')->textInput() ?>
                        </div>

                        <div class="col-12">
                            <?= $form->field($model, 'brief', ['enableClientValidation' => false])->textarea(['rows' => 6, 'id' => 'ckbasic']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'description2', ['enableClientValidation' => false])->textArea(['rows' => 6, 'class' => 'ckeditor']); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'description', ['enableClientValidation' => false])->textArea(['class' => 'ckeditor']); ?>
                        </div>
                    </div>



                    <div class="row d-none">
                        <div class="col-12">
                            <?= $form->field($model, 'description3', ['enableClientValidation' => false])->textArea(['class' => 'ckeditor']); ?>
                        </div>
                    </div>



                    <?php
                    if (false):
                        for ($i=2; $i <= 6; $i++): ?>
                            <div class="row">
                                <div class="col-12">
                                    <?= $form->field($model, 'description' . $i, ['enableClientValidation' => false])->textArea(['class' => 'ckeditor']); ?>
                                </div>
                            </div>
                        <?php endfor;
                    endif; ?>
                </div>
            </div>

            <!-- Begin box_image_product -->
            <div class="white_bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6"><strong class="title_box">Ảnh sản phẩm</strong></div>
                        <div class="col-6 text-right">
                            <a href="#" class="fileinput-button">
                                Thêm ảnh
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="fileupload" type="file" name="files[]" data-url="<?=Url::to(['attachment/upload']); ?>" data-form-data='{"pid": <?=($model->id)?$model->id:$timestamp; ?>}' multiple>
                            </a>
                        </div>
                    </div>
                    <div class="box_image_product">
                        <?= $form->field($model, 'path')->hiddenInput(['id' => 'path_placeholder'])->label(false); ?>
                        <div id="progress" class="rounded" style="opacity: 0;">
                            <div class="bar" style="width: 0%;"></div>
                        </div>

                        <ul id="list_imgs">
                            <?php
                            $imgs = $model->imgs;
                            if (!empty($imgs)) {
                                foreach ($imgs as $row) {
                                    ?>
                                    <li data-id="<?=$row->id; ?>">
                                        <p class="move"><img class="move" src="<?=Yii::$app->urlManagerFrontend->baseUrl."/".$row->path; ?>" alt="<?=$row->path; ?>"></p>
                                        <span>
                                            <a href="#" title="Xem ảnh"><i class="fas fa-search-plus"></i></a>
                                            <a class="copy_img" href="#" title="Copy url"><i class="far fa-copy"></i></a>
                                            <a class="delete_img" href="#" title="Xóa ảnh"><i class="far fa-trash-alt"></i></a>
                                        </span>
                                    </li>
                                    <?php
                                }
                            }
                            //                            if ($model->isNewRecord) {
                            //                                $imgs = Attachment::getTempImgs();
                            //                                if (!empty($imgs)) {
                            //                                    foreach ($imgs as $row) {
                            //                                        ?>
                            <!--                                        <li data-id="--><?//=$row['id']; ?><!--">-->
                            <!--                                            <p class="move"><img src="--><?//=Yii::$app->urlManagerFrontend->baseUrl."/".$row['path']; ?><!--" alt="--><?//=$row['path']; ?><!--"></p>-->
                            <!--                                            <span>-->
                            <!--                                                <a href="#" title="Xem ảnh"><i class="fas fa-search-plus"></i></a>-->
                            <!--                                                <a class="copy_img" href="#" title="Copy url"><i class="far fa-copy"></i></a>-->
                            <!--                                                <a class="delete_img" href="#" title="Xóa ảnh"><i class="far fa-trash-alt"></i></a>-->
                            <!--                                            </span>-->
                            <!--                                        </li>-->
                            <!--                                        --><?php
                            //                                    }
                            //                                }
                            //                            }
                            ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- End box_image_product -->


            <!-- Begin box_image_product -->
            <div class="white_bg d-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6"><strong class="title_box">Tin tức liên quan</strong></div>
                        <div class="col-6 text-right">
                            <a href="#">Mở rộng</a>
                        </div>
                    </div>
                    <div id="relatedNews" class="related_box">
                        <?= $form->field($model, 'news_ids', ['template' => '{input}'])->hiddenInput(['class' => 'news_ids_placeholder'])->label(false); ?>
                        <div class="row no-gutters search_rbox" id="searchForm">
                            <div class="col-8 form-group">
                                <input class="form-control" autocomplete="off" type="text" name="title" placeholder="Từ khóa tìm kiếm...">
                            </div>
                            <div class="col-4 form-group">
                                <?=Html::dropDownList('catnews_id', '', CatNews::getAllCatNewsDDL(), ["class" => "form-control", 'prompt' => 'Chọn danh mục...']); ?>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col-6">
                                <ul class="all_rbox"></ul>
                            </div>
                            <div class="col-6">
                                <ul class="selected_rbox"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End box_image_product -->


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
                                    $base_url = $_SERVER['SERVER_NAME'].Yii::$app->urlManagerFrontend->createUrl(['site/product', 'id' => $model->id, 'name' => $model->url]);
                                    ?>
                                    <h3><?=($model->seo_title) ? $model->seo_title : $model->name; ?></h3>
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
        <!-- End left -->


        <!-- Begin right -->
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
                            <?= $form->field($model, 'hot')->checkBox() ?>
                        </div>
                    </div>
                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'best')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'feature')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'active')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line line_ddl">
                        <div class="col-7">
                            <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status'], ['prompt' => 'Vui lòng chọn...']); ?>
                        </div>

                        <div class="col-5">
                            <?= $form->field($model, 'hits')->textInput() ?>
                        </div>
                    </div>

                    <div class="row line">
                        <div class="col-7">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
                        </div>

                        <div class="col-5">
                            <?= $form->field($model, 'ord')->textInput() ?>
                        </div>
                    </div>

                    <br />
                </div>
            </div>

            <div class="white_bg vina-right">
                <div class="container-fluid">

                    <strong class="title_box" style="margin-bottom: 0;">Phân loại</strong>

                    <div class="row line line_ddl">
                        <div class="col-12">
                            <?= $form->field($model, 'category_id')->dropDownList(Cat::getCatDDL(), ['prompt' => 'Vui lòng chọn...']); ?>
                        </div>
                    </div>

                    <div class="row line line_ddl d-none">
                        <div class="col-12">
                            <?= $form->field($model, 'cat_id')->dropDownList(Cat::getCatDDL(), ['class' => 'mulselect_cat', 'prompt' => 'Vui lòng chọn...', 'multiple' => 'multiple']); ?>
                        </div>
                    </div>

                    <?php $brandList = Brand::getBrandDDL();
                    if (!empty($brandList)): ?>
                        <div class="row line line_ddl">
                            <div class="col-12">
                                <?= $form->field($model, 'brand_id')->dropDownList($brandList, ['prompt' => 'Vui lòng chọn...']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <?php
            $propertyList = Property::getProperty();
            if (!empty($propertyList)) :
                ?>
                <div class="white_bg vina-right">
                    <div class="container-fluid">

                        <strong class="title_box" style="margin-bottom: 0;">Thông số</strong>

                        <?php foreach ($propertyList as $row) : ?>
                            <div class="row line line_ddl">
                                <div class="col-12">
                                    <?= $form->field($model, "property[{$row->id}]")->dropDownList(PropertyValue::getPropertyValueDDL($row->id), ['class' => 'mulselect_cat', 'multiple' => 'multiple'])->label($row->name); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (!empty($model->id)): ?>
                            <a href="<?= Url::toRoute(['product/save-new']) ?>" class="btn d-block btn-info rounded-sm submit_redirect_image">Phân loại sản phẩm</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>


            <div class="white_bg vina-right d-none" style="padding-bottom: 0;">
                <div class="container-fluid">

                    <!-- Begin tải ảnh đại diện -->
                    <strong class="title_box">Tags tìm kiếm</strong>
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'tags')->hiddenInput(['maxlength' => true, 'placeholder' => 'Vd: Samsung, Vinfast, Apple,...', 'data-role' => 'tagsinput'])->label(false); ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- End right -->
    </div>

    <div class="modal fade bd-example-modal-lg" id="picture-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Phân loại sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="property-image">
                        <div class="row">
                            <div class="col-5">
                                <div class="product-property">
                                    <!-- <strong class="title-box">Màu tóc</strong>
                                    <a class='alert alert-primary property-value-option' data-id='85' data-name='Trắng' href='#'>Trắng</a>-->
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="product-images d-none">

                                </div>
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
$this->registerJsFile("@web/jupload/js/main.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
$this->registerJsFile("@web/ckeditor/ckeditor.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);
$this->registerJs('CKEDITOR.replace( "ckbasic", { customConfig: "'.Yii::$app->urlManager->baseUrl.'/ckeditor/config_basic.js" } );', \yii\web\View::POS_END);
$this->registerJs('CKEDITOR.replace( "ckbasic2", { customConfig: "'.Yii::$app->urlManager->baseUrl.'/ckeditor/config_basic.js" } );', \yii\web\View::POS_END);
?>
