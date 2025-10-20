<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Cat;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$cat_filter = Cat::getCatDDL();

$this->title = 'Quản lý';
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm và Xóa', '#', ['class' => 'btn btn-primary  rounded-sm d-none d-md-inline-block add_delete_fast']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-times"></i> Xóa', '#', ['class' => 'btn btn-danger rounded-sm d-none d-md-inline-block', 'onclick' => '{ if (confirm("Bạn chắc chắn muốn xóa các mục này ?")){  $("#delete_items_frm").attr("action", "temp-product/index");$("#delete_items_frm").submit();} return false; }']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<!-- Begin box_image_product -->
<div class="white_bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6"><strong class="title_box">Ảnh sản phẩm</strong></div>
            <div class="col-6 text-right">
                <a href="#" class="fileinput-button">
                    Thêm ảnh
                    <!-- The file input field used as target for the file upload widget -->
                    <!--                <input id="fileupload" type="file" name="files[]" data-url="--><?//=Url::to(['temp-product/upload']); ?><!--" multiple>-->
                    <?php $timestamp = time(); ?>
                    <input id="fileupload" type="file" name="files[]" data-url="<?=Url::to(['temp-product/upload']); ?>" data-form-data='{"pid": <?=$timestamp ?>}' multiple>
                </a>
            </div>
        </div>
        <div class="box_image_product">
            <div id="progress" class="rounded" style="opacity: 0;">
                <div class="bar" style="width: 0%;"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- End box_image_product -->

<div class="white_bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 d-flex align-items-center"><strong class="title_box mb-0">Cập nhật nhanh</strong></div>
            <div class="col-3">
                <input type="text" name="product_name" id="product-name" class="form-control" placeholder="Nhập tên sản phẩm, %i là số thứ tự" />
            </div>
            <div class="col-2">
                <input type="text" name="product_price" id="product-price" class="form-control" placeholder="Nhập giá sản phẩm" />
            </div>
            <div class="col-3">
                <?=
                Html::dropDownList('product-cat-id', 0, $cat_filter, [
                    'class' => 'form-control',
                    "prompt" => "Vui lòng chọn...",
                    'style' => 'height:38px',
                    'id' => 'product-cat-id'
                ]);
                ?>
            </div>

            <div class="col-2 text-right">
                <button type="button" class="btn btn-primary rounded-sm w-100" id="btUpdateInfo">Cập nhật thông tin</button>
            </div>
        </div>
    </div>
</div>

<?=Html::beginForm("temp-product/add", 'POST', ['id' => 'delete_items_frm']);?>


<div class="white_bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <strong class="title_box">Mô tả sản phẩm</strong>
                <div>
                    <textarea name="product-brief" id="product-brief" class="ckeditor" rows="6"></textarea>
                </div>
            </div>
            <div class="col-6">
                <strong class="title_box">Chi tiết sản phẩm</strong>
                <div>
                    <textarea name="product-desc" id="product-desc" class="ckeditor" rows="6"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="white_bg">
    <div class="temp-product-index">
        <?= Html::input('hidden', 'check_add_delete', 0, ['class' => 'form-control add_delete_input']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => '{items}<div class="row no-gutters"><div class="col-md-6">{pager}</div><div class="col-md-6">{summary}</div></div>',
            'options' => ['data-url' => Url::to($this->context->id."/update-ajax"), 'class' => 'grid-view'],
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'contentOptions' => ['style' => 'text-align: center', 'class' => Yii::$app->params['dnone']],
                    'filterOptions' => ['class' => Yii::$app->params['dnone']],
                    'headerOptions' => ['class' => Yii::$app->params['dnone']]
                ],

                [
                    'attribute'=>'path',
                    'value'=>function ($data) {
                        if ($data->path)
                            return Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/'.$data->path, ['title' => $data->name, 'width' => 50, 'height' => 30]);
                        return " ";
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center;'],
                ],

                [
                    'attribute'=>'name',
                    'value'=>function ($data) {
                        return Html::input('text', 'name', $data->name, ['class' => 'form-control cajax input-name','id'=>$data->id,'data-attr'=>'name']);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute'=>'price',
                    'value'=>function ($data) {
                        return Html::input('text', 'price', $data->price, ['class' => 'form-control cajax input-price','id'=>$data->id,'data-attr'=>'price']);
                    },
                    'format' => 'raw',
                ],

                [
                    'attribute'=>'cat_id',
                    'filter'=>$cat_filter,
                    'value'=>function ($data) use ($cat_filter) {
                        return Html::dropDownList('cat_id_ddl', $data->cat_id, $cat_filter, [
                            "prompt" => "Vui lòng chọn...",
                            "data-attr" => "cat_id",
                            "class" => "cajax input-cat"
                        ]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:180px; text-align: center', 'class' => Yii::$app->params['dnone']],
                    'filterOptions' => ['class' => Yii::$app->params['dnone']],
                    'headerOptions' => ['class' => Yii::$app->params['dnone']]
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'header' => 'Xóa',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center; font-size: 14px; line-height: 18px;'],
                    'buttons' => [
                        'delete' => function ($url) {
                            return Html::a('<i class="far fa-trash-alt"></i>', $url, [
                                'title' => 'Xóa',
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete?'),
                                'data-method' => 'post', 'data-pjax' => '0',
                            ]);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>
<?= Html::endForm();?>

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
$this->registerJsFile("@web/jupload/js/temp.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
]);

$this->registerJsFile("@web/ckeditor/ckeditor.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_HEAD
 ]);
 $this->registerJs('CKEDITOR.replace( "ckbasic", { customConfig: "'.Yii::$app->urlManager->baseUrl.'/ckeditor/config_basic.js" } );', \yii\web\View::POS_END);



$this->registerJs(
    "
    CKEDITOR.instances['product-brief'].setData(localStorage.getItem('product-brief'));;
    CKEDITOR.instances['product-desc'].setData(localStorage.getItem('product-desc'));

    $('#product-name').val(localStorage.getItem('product-name'));
    $('#product-price').val(localStorage.getItem('product-price'));
    $('#product-cat-id').val(localStorage.getItem('product-cat-id'));

    $('#btUpdateInfo').on('click', function() { 
        var name = $('#product-name').val();
        var price = parseFloat($('#product-price').val());
        var cat_id = parseInt($('#product-cat-id').val());

        localStorage.setItem('product-name', name);
        localStorage.setItem('product-price', isNaN(price) ? '' : price);
        localStorage.setItem('product-cat-id', isNaN(cat_id) ? '' : cat_id);

        if (name.length > 0) {
            $('.input-name').each(function(index) {
                $(this).val(name.replace(/%i/g, index + 1));
            });
        }

        if (price.length > 0) 
            $('.input-price').val(price);

        if (cat_id > 0) 
            $('.input-cat').val(cat_id);

        $('.input-name').trigger('change');
        $('.input-price').trigger('change');
        $('.input-cat').trigger('change');
        localStorage.removeItem('product-brief');
        localStorage.removeItem('product-desc');
    });",
    yii\web\View::POS_READY,
    'my-button-handler'
);
