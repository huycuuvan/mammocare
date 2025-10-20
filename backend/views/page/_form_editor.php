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
<div class="page-form">
    <div class="row row-wrapper">
        <div class="col-md-9">

            <div class="white_bg">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <?= $form->field($model, 'content', ['enableClientValidation' => false])->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'editor')->hiddenInput()->label(false); ?>

                </div>
            </div>

            <div class="white_bg">
                <div class="container-fluid">
                    <div class="editor-box"><?= $model->content ?></div>
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
                                
                                $base_url = $_SERVER['SERVER_NAME'].Yii::$app->urlManagerFrontend->createUrl(['site/page', 'id' => $model->id, 'name' => $model->url]);
                                  ?>
                                  <h3><?=($model->seo_title) ? $model->seo_title : $model->title; ?></h3>
                                  <a href="http://<?=$base_url; ?>" target="_blank">https://<?= $base_url; ?></a>
                                  <p><?=($model->seo_desc) ? $model->seo_desc : strip_tags($model->content); ?></p>
                                  <?php
                              };
                              ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid collapse show" id="collapse_seobox">
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

        <div class="col-md-3">

            <div class="white_bg gray_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">
                    <strong class="title_box">Hiển thị</strong>

                    <div class="row line">
                        <div class="col-12">
                            <?= $form->field($model, 'active')->checkBox() ?>
                        </div>
                    </div>

                    <div class="row line line_ddl">
                        <div class="col-12">
                            <?= $form->field($model, 'lang_id')->dropDownList(Language::getLanguageDDL($model->lang_id ? $model->lang_id : Yii::$app->language)); ?>
                        </div>
                    </div>

                </div>
            </div>
            
            <?php $arrCode = [
                'Fade - Phai mờ' => [
                    'Mờ từ dưới lên trên' => 'data-aos="fade-up" data-aos-delay="500"',
                    'Mờ từ trên xuống dưới' => 'data-aos="fade-down" data-aos-delay="500"',
                    'Mờ từ trái sang phải' => 'data-aos="fade-right" data-aos-delay="500"',
                    'Mờ từ phải lên trái' => 'data-aos="fade-left" data-aos-delay="500"'
                ],
                'Flip - Lật' => [
                    'Lật từ dưới lên' => 'data-aos="flip-up" data-aos-delay="500"',
                    'Lật từ trên xuống' => 'data-aos="flip-down" data-aos-delay="500"',
                    'Lật từ trái sang phải' => 'data-aos="flip-left" data-aos-delay="500"',
                    'Lật từ phải sang trái' => 'data-aos="flip-right" data-aos-delay="500"'
                ],
                'Zoom - Thu phóng' => [
                    'Phóng to' => 'data-aos="zoom-in" data-aos-delay="500"',
                    'Phóng to hướng lên' => 'data-aos="zoom-in-up" data-aos-delay="500"',
                    'Phóng to hướng xuống' => 'data-aos="zoom-in-down" data-aos-delay="500"',
                    'Phóng to phải sang trái' => 'data-aos="zoom-in-left" data-aos-delay="500"',
                    'Phóng to trái sang phải' => 'data-aos="zoom-in-right" data-aos-delay="500"',
                    'Thu nhỏ' => 'data-aos="zoom-out" data-aos-delay="500"',
                    'Thu nhỏ hướng lên' => 'data-aos="zoom-out-up" data-aos-delay="500"',
                    'Thu nhỏ hướng xuống' => 'data-aos="zoom-out-down" data-aos-delay="500"',
                    'Thu nhỏ phải sang trái' => 'data-aos="zoom-out-left" data-aos-delay="500"',
                    'Thu nhỏ trái sang phải' => 'data-aos="zoom-out-right" data-aos-delay="500"'
                ]
            ];?>

            <div class="white_bg gray_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">
                    <div class="effect-code">
                        <strong class="title_box">Hiệu ứng </strong>

                        <?php foreach ($arrCode as $name => $arr): ?>
                        <div class="row">
                            <div class="col-12">

                                <a class="title-effect font-weight-bold"><?= $name ?></a>
                                <div class="box-code">
                                    <?php foreach ($arr as $title => $code) : ?>
                                    <p>
                                        <span><?= $title ?>:</span>
                                        <input class="copyCode" readonly type="text" value="<?= htmlentities($code) ?>" /></input>
                                    </p>
                                    <?php endforeach; ?>
                                </div>
                            
                            </div>
                        </div>
                        <?php endforeach; ?>
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
$this->registerJsFile("@web/ckfinder/ckfinder.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
 ]);
?>

<?php
$ckfinder_path = Url::base(true) . '/ckfinder/ckfinder.html?type=Images';

$js = <<<JS
    var builder = new ContentBuilder({
        container: '.editor-box',
        snippetOpen: true,
        row: 'row',
        cols: ['col-md-1', 'col-md-2', 'col-md-3', 'col-md-4', 'col-md-5', 'col-md-6', 'col-md-7', 'col-md-8', 'col-md-9', 'col-md-10', 'col-md-11', 'col-md-12'],
        // clearPreferences: true,
        assetPath: '../../asset-builder/',
        fontAssetPath: '../../asset-builder/fonts/',
        snippetPath: '../asset-builder/minimalist-blocks/',
        snippetData: '../asset-builder/minimalist-blocks/snippetlist.html',
        snippetPathReplace: ['assets/minimalist-blocks/', '../asset-builder/minimalist-blocks/'],
        snippetCategories: [
            [120,"Trình bày cơ bản"],
            [118,"Trình bày văn bản"],
            [101,"Trình bày tiêu đề"],
            [119,"Trình bày Nút"],
            [102,"Trình bày hình ảnh"],
            [103,"Trình bày Profile"],
            [116,"Trình bày liên hệ"],
            [104,"Trình bày sản phẩm"],
            [105,"Trình bày các tính năng"],
            [106,"Trình bày tiến trình"],
            [107,"Trình bày giá bán"],
            [108,"Trình bày Kỹ năng"],
            [109,"Trình bày Thành tựu"],
            [110,"Trình bày Trích dẫn"],
            [111,"Trình bày Đối tác"],
            [112,"Trình bày Tính năng"],
            [113,"Trình bày Không tìm thấy"],
            [114,"Trình bày Sắp ra mắt"],
            [115,"Trình bày hỏi đáp, giúp đỡ"]
        ],
        
        onImageSelectClick: function(selEv) {
            console.log(selEv);
            CKFinder.popup( {
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function( finder ) {
                    finder.on('files:choose', function( evt ) {
                        var file = evt.data.files.first();

                        jQuery(selEv.targetInput).val(file.getUrl());
                    } );
                }

            } );
        }

    });

    var checkSave = false;

    $('form').submit(function() {
        checkSave = true;

        //Get html
        var html = builder.html(); //Get content

        //Submit the html to the server for saving. For example, if you're using html form:
        document.querySelector('#page-content').value = html;
    });

    $('.effect-code .title_box').click(function() {
        $('.effect-code').toggleClass('show');

        return false;
    });

    $('.effect-code .copyCode').click(function() {
        $(this).select();
        document.execCommand('copy');
    });

    window.onbeforeunload = confirmExit;
    function confirmExit() {
        if (!checkSave)
            return "Bạn chưa lưu các thay đổi. Bạn có chắc chắn muốn chuyển trang?";
    }
JS;

$this->registerJs($js);