<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý';
$this->params['breadcrumbs'][] = ['label' => 'Ngôn ngữ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-times"></i> Xóa', '#', ['class' => 'btn btn-danger rounded-sm d-none d-md-inline-block', 'onclick' => '{ if (confirm("Bạn chắc chắn muốn xóa các mục này ?")) $("#delete_items_frm").submit(); return false; }']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);

?>
<div class="white_bg">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="language-index">
        <?=Html::beginForm("", 'POST', ['id' => 'delete_items_frm']);?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => '{items}<div class="row no-gutters"><div class="col-md-6">{pager}</div><div class="col-md-6">{summary}</div></div>',
                'options' => ['data-url' => Url::to($this->context->id."/update-ajax"), 'class' => 'grid-view'],
                'columns' => [

                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'contentOptions' => ['style' => 'width:40px; text-align: center', 'class' => Yii::$app->params['dnone']],
                        'filterOptions' => ['class' => Yii::$app->params['dnone']],
                        'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    ],

                    [
                        'attribute'=>'thumb',
                        'value'=>function ($data) {
                            return Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/'.$data->path, ['title' => $data->name, 'alt' => $data->name, 'width' => 35, 'height' => 24]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 70px; text-align: center'],
                    ],

                    [
                        'attribute'=>'name',
                        'value'=>function ($data) {
                            return Html::a($data->name, ['update', 'id' => $data->id]);
                        },
                        'format' => 'raw',
                    ],

                    'code',
                    'iso_code',

                    [
                        'attribute'=>'ord',
                        'value'=>function ($data) {
                            return Html::textInput('ord_txt', $data->ord, ["data-attr" => "ord", "class" => "cajax"]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 80px; text-align: center', 'class' => Yii::$app->params['dnone']],
                        'filterOptions' => ['class' => Yii::$app->params['dnone']],
                        'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    ],

                    [
                        'attribute'=>'defa',
                        'filter'=>[0 => 'Không', 1 => 'Có'],
                        'label'=>'Mặc định',
                        'value'=>function ($data) {
                            return Html::radio('defa[]', ($data->defa)?1:0, ["data-attr" => "defa", "class" => "cajax"]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:80px; text-align: center'],
                    ],

                    [
                        'attribute'=>'active',
                        'filter'=>[0 => 'Không', 1 => 'Có'],
                        'label'=>'H.Thị',
                        'value'=>function ($data) {
                            return Html::checkbox('active[]', ($data->active)?1:0, ["data-attr" => "active", "class" => "cajax"]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:70px; text-align: center'],
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'header' => 'Xóa',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:70px; text-align: center; font-size: 14px; line-height: 18px;'],
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
