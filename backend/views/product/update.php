<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Cập nhật';
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="far fa-save"></i> Lưu lại', ['index'], ['class' => 'btn btn-info rounded-sm active_form']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);

$tasks = $this->params['task_allowed'];

if (in_array('copy', $tasks['product'])) {
    $this->params['vn-navbar'][] = Html::a('<i class="fas fa-copy"></i> Nhân bản', 'product/copy?id=' . $model->id, ['class' => 'btn btn-success rounded-sm mr-3']);
}
?>
<div class="product-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
