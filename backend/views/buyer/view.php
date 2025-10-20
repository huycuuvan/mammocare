<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Chi tiết';
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['product/index']];
$this->params['breadcrumbs'][] = ['label' => 'Đơn hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="far fa-save"></i> Lưu lại', ['index'], ['class' => 'btn btn-info rounded-sm active_form']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="buyer-view" style="background: #fff; padding: 10px 0;">

  <?=$model->bill_json; ?>

    <?php /*DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fullname',
            'mobile',
            'email:email',
            'content:ntext',
            'address',
            'ordered_time',
            'bill_json:html'
        ],
    ])*/ ?>

</div>
