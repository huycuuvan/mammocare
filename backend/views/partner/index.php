<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Partner;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Quản lý';
$this->params['breadcrumbs'][] = ['label' => 'Quảng cáo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$tasks = $this->params['task_allowed'];
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-times"></i> Xóa', '#', ['class' => 'btn btn-danger rounded-sm d-none d-md-inline-block', 'onclick' => '{ if (confirm("Bạn chắc chắn muốn xóa các mục này ?")) $("#delete_items_frm").submit(); return false; }']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
$filter_position = Partner::getPosition();
if (in_array('copy', $tasks['partner']))
  $this->params['vn-navbar'][] = Html::a('<i class="fas fa-copy"></i> Sao chép ngôn ngữ', ['copy'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="white_bg">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="partner-index">
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
                        'contentOptions' => ['style' => 'width: 70px; text-align: center'],
                    ],
                    [
                        'attribute'=>'name',
                        'value'=>function ($data) {
                            return Html::a($data->name, ['update', 'id' => $data->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute'=>'position',
                        'filter'=>$filter_position,
                        'value'=>function ($data) use ($filter_position) {
                            return Html::dropDownList('position_ddl', $data->position, $filter_position, [
                                "prompt" => "Vui lòng chọn...",
                                "data-attr" => "position",
                                "class" => "cajax"
                                ]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width:200px; text-align: center'],
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
                        'attribute'=>'home',
                        'filter'=>[0 => 'Không', 1 => 'Có'],
                        'label'=>'T.Chủ',
                        'value'=>function ($data) {
                            return Html::checkbox('home[]', ($data->home)?1:0, ["data-attr" => "home", "class" => "cajax"]);
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
