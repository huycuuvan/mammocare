<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Cat;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đặt phòng';
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = $this->title;

//$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);


$cat_filter = ArrayHelper::map(Cat::find()->where(['active' => 1, 'parent' => 0])->asArray()->all(), 'id', 'name');
?>

<div class="white_bg">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="cat-index">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => '{items}<div class="row no-gutters"><div class="col-md-6">{pager}</div><div class="col-md-6">{summary}</div></div>',
            'options' => ['data-url' => Url::to($this->context->id."/update-ajax"), 'class' => 'grid-view'],
            'columns' => [

                [
                    'attribute'=>'name',
                    'value'=>function ($data) {
                        return Html::a($data->name, ['view', 'id' => $data->id]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => ''],
                ],
                'phone',

                [
                    'attribute'=>'address',
                    'contentOptions' => ['class' => Yii::$app->params['dnone']],
                    'filterOptions' => ['class' => Yii::$app->params['dnone']],
                    'headerOptions' => ['class' => Yii::$app->params['dnone']]
                ],
                [
                    'attribute' => 'date_from',
                    'value'=>function ($data) {
                        return date("d-m-Y",strtotime($data->date_from));
                    },
                    'filter' => \yii\jui\DatePicker::widget([
                        'model'=>$searchModel,
                        'attribute'=>'date_from',
                        'language' => 'vi',
                        'options' => ['class' => 'form-control'],
                        'dateFormat' => 'dd/MM/yyyy',
                    ]),
                    'format' => 'html',
                ],
                [
                    'attribute' => 'date_to',
                    'value'=>function ($data) {
                        return date("d-m-Y",strtotime($data->date_to));
                    },
                    'filter' => \yii\jui\DatePicker::widget([
                        'model'=>$searchModel,
                        'attribute'=>'date_to',
                        'language' => 'vi',
                        'options' => ['class' => 'form-control'],
                        'dateFormat' => 'dd/MM/yyyy',
                    ]),
                    'format' => 'html',
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'header' => 'Xóa',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'contentOptions' => ['style' => 'text-align: center; font-size: 14px; line-height: 18px; width:80px;'],
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
