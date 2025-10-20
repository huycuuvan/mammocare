<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\CatDoctor;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\components\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$filter_catnews = CatDoctor::getParentDDL();
$this->title = 'Chuyên khoa';
$this->params['breadcrumbs'][] = ['label' => 'Bác sĩ', 'url' => ['supporter/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="white_bg">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="news-index">
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
                        if ($data->thumb)
                            return Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/'.$data->thumb, ['title' => $data->name, 'alt' => $data->name, 'width' => 60, 'height' => 40]);

                        return " ";
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center'],
                ],

                [
                    'attribute'=>'name',
                    'value'=>function ($data) {
                        return Html::a($data->name, ['update', 'id' => $data->id]);
                    },
                    'format' => 'raw',
                ],

                [
                    'attribute'=>'parent',
                    'filter'=>$filter_catnews,
                    'value'=>function ($data) use ($filter_catnews) {
                        return Html::dropDownList('parent_ddl', $data->parent, $filter_catnews, [
                            "prompt" => "Vui lòng chọn...",
                            "data-attr" => "parent",
                            "class" => "cajax"
                        ]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width:180px; text-align: center', 'class' => Yii::$app->params['dnone']],
                    'filterOptions' => ['class' => Yii::$app->params['dnone']],
                    'headerOptions' => ['class' => Yii::$app->params['dnone']]
                ],
                [
                    'attribute'=>'home',
                    'filter'=>[0 => 'Không', 1 => 'Có'],
                    'value'=>function ($data) {
                        return Html::checkbox('active_chb[]', $data->home?1:0, ["data-attr" => "home", "class" => "cajax"]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center', 'class' => Yii::$app->params['dnone']],
                    'filterOptions' => ['class' => Yii::$app->params['dnone']],
                    'headerOptions' => ['class' => Yii::$app->params['dnone']]
                ],

                [
                    'attribute'=>'active',
                    'filter'=>[0 => 'Không', 1 => 'Có'],
                    'value'=>function ($data) {
                        return Html::checkbox('active_chb[]', $data->active?1:0, ["data-attr" => "active", "class" => "cajax"]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'text-align: center'],
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
        <?= Html::endForm(); ?>
    </div>
</div>
<?php
$this->registerJsFile("@web/js/menu.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_END]
);
?>
