<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Cat;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý';
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="far fa-copy"></i> Thêm nhanh', ['temp-product/index'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-times"></i> Xóa', '#', ['class' => 'btn btn-danger rounded-sm d-none d-md-inline-block', 'onclick' => '{ if (confirm("Bạn chắc chắn muốn xóa các mục này ?")) $("#delete_items_frm").submit(); return false; }']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);

$cat_list = Cat::getCatDDL();
?>
<div class="white_bg">
    <div class="product-index">
        <?= $this->render('_search', [
            'model' => $searchModel
        ]); ?>

        <?=Html::beginForm("", 'POST', ['id' => 'delete_items_frm']);?>
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
                                return Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/'.$data->path, ['title' => $data->name, 'width' => 60, 'height' => 40]);
                            return " ";
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align: center;'],
                    ],

                    [
                        'attribute'=>'name',
                        'value'=>function ($data) {
                            return Html::a($data->name, ['update', 'id' => $data->id]);
                        },
                        'format' => 'raw',
                    ],

                    // 'status',

                    [
                        'attribute'=>'sale',
                        'value'=>function ($data) {
                            return Html::textInput('sale_txt', $data->sale, ["data-attr" => "sale", "class" => "cajax", 'style' => 'color: #e00; font-weight: 300;']);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 100px; text-align: center', 'class' => Yii::$app->params['dnone']],
                        'filterOptions' => ['class' => Yii::$app->params['dnone']],
                        'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    ],

                    [
                        'attribute'=>'category_id',
                        'filter'=>$cat_list,
                        'value'=>function ($data) use ($cat_list) {
                            return Html::dropDownList('category_id_ddl', $data->category_id, $cat_list, [
                                "prompt" => "Vui lòng chọn...",
                                "data-attr" => "category_id",
                                "class" => "cajax"
                                ]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:180px; text-align: center', 'class' => Yii::$app->params['dnone']],
                        'filterOptions' => ['class' => Yii::$app->params['dnone']],
                        'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    ],

                    // [
                    //     'attribute'=>'type_id',
                    //     'filter'=>$type_filter,
                    //     'value'=>function ($data) use ($type_filter) {
                    //         return Html::dropDownList('type_id_ddl', $data->type_id, $type_filter, [
                    //             "prompt" => "Vui lòng chọn...",
                    //             "data-attr" => "type_id",
                    //             "class" => "cajax"
                    //             ]);
                    //     },
                    //     'format' => 'raw',
                    //     'contentOptions' => ['style' => 'width:180px; text-align: center', 'class' => Yii::$app->params['dnone']],
                    //     'filterOptions' => ['class' => Yii::$app->params['dnone']],
                    //     'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    // ],



                    [
                        'attribute'=>'home',
                        'filter'=>[0 => 'Không', 1 => 'Có'],
                        'label'=>'T.Chủ',
                        'value'=>function ($data) {
                            return Html::checkbox('home[]', ($data->home)?1:0, ["data-attr" => "home", "class" => "cajax"]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align: center'],
                    ],
                    [
                        'attribute'=>'hot',
                        'label'=>'N.Bật',
                        'filter'=>[0 => 'Không', 1 => 'Có'],
                        'value'=>function ($data) {
                            return Html::checkbox('hot[]', ($data->hot)?1:0, ["data-attr" => "hot", "class" => "cajax"]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align: center', 'class' => Yii::$app->params['dnone']],
                        'filterOptions' => ['class' => Yii::$app->params['dnone']],
                        'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    ],
//                   [
//                       'attribute'=>'best',
//                       'filter'=>[0 => 'Không', 1 => 'Có'],
//                       'label'=>'Hot',
//                       'value'=>function ($data) {
//                           return Html::checkbox('best[]', ($data->best)?1:0, ["data-attr" => "best", "class" => "cajax"]);
//                       },
//                       'format' => 'raw',
//                       'contentOptions' => ['style' => 'text-align: center'],
//                   ],
//                   [
//                    'attribute'=>'feature',
//                    'filter'=>[0 => 'Không', 1 => 'Có'],
//                    'label'=>'Hot Icon',
//                    'value'=>function ($data) {
//                        return Html::checkbox('feature[]', ($data->feature)?1:0, ["data-attr" => "feature", "class" => "cajax"]);
//                    },
//                    'format' => 'raw',
//                    'contentOptions' => ['style' => 'text-align: center'],
//                ],


                    [
                        'attribute'=>'ord',
                        'value'=>function ($data) {
                            return Html::textInput('ord_txt', $data->ord, ["data-attr" => "ord", "class" => "cajax", 'style' => 'font-weight: 300;']);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:80px; text-align: center', 'class' => Yii::$app->params['dnone']],
                        'filterOptions' => ['class' => Yii::$app->params['dnone']],
                        'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    ],

                    [
                        'attribute'=>'active',
                        'filter'=>[0 => 'Không', 1 => 'Có'],
                        'label'=>'H.Thị',
                        'value'=>function ($data) {
                            return Html::checkbox('active[]', ($data->active)?1:0, ["data-attr" => "active", "class" => "cajax"]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align: center'],
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
        <?= Html::endForm();?>
    </div>
</div>
