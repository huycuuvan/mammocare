<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Cat;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;

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
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'address',
                'phone',
                'email',
                'note',
                'date_from',
                'date_to',
                'adult',
                'child',
                [
                    'attribute' => 'product_id',
                    'value' => $model->product->name,
                ],
            ],
        ]) ?>
    </div>
</div>
