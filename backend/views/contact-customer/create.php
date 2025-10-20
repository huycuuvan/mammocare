<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactCustomer */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Khách hàng liên hệ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="far fa-save"></i> Lưu lại', ['index'], ['class' => 'btn btn-info rounded-sm active_form']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);

?>
<div class="contact-customer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
