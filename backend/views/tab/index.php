<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Tab;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý';
$this->params['breadcrumbs'][] = ['label' => 'Tab ngắn', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$tasks = $this->params['task_allowed'];

if (in_array('create', $tasks['tab'])) {
  $this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
  $this->params['vn-navbar'][] = Html::a('<i class="fas fa-times"></i> Xóa', '#', ['class' => 'btn btn-danger rounded-sm d-none d-md-inline-block', 'onclick' => '{ if (confirm("Bạn chắc chắn muốn xóa các mục này ?")) $("#delete_items_frm").submit(); return false; }']);
}

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);


if (in_array('copy', $tasks['tab']))
  $this->params['vn-navbar'][] = Html::a('<i class="fas fa-copy"></i> Sao chép ngôn ngữ', ['copy'], ['class' => 'btn btn-success rounded-sm']);

?>
<div class="white_bg">
    <div class="tab-index">
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
                        'attribute'=>'code',
                        'value'=>function ($data) {
                            return Html::a($data->code, ['update', 'id' => $data->id]);
                        },
                        'format' => 'raw',
                    ],

                    [
                        'attribute'=>'name',
                        'value'=>function ($data) {

                            if ($data->type == 1)
                              return Html::textArea('name_txt', $data->name, ["data-attr" => "name", "class" => "cajax form-control", 'style' => 'width:100%;']);
                            else
                              return Html::a('<img src="' . Url::base(true) . '/../' .$data->path . '" style="max-height:60px;max-width:100%;" />', ['update', 'id' => $data->id]);;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 400px; text-align:left;', 'class' => Yii::$app->params['dnone']],
                        'filterOptions' => ['class' => Yii::$app->params['dnone']],
                        'headerOptions' => ['class' => Yii::$app->params['dnone']]
                    ],


                    [
                        'attribute'=>'type',
                        'value'=>function ($data) {
                            return Tab::getTypeName($data->type);
                        },
                        'contentOptions' => ['style' => 'text-align: center; font-size: 14px; line-height: 18px;'],
                        'format' => 'raw',
                    ],

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
