<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Liên hệ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$tasks = $this->params['task_allowed'];

if (in_array('copy', $tasks['contact']))
  $this->params['vn-navbar'][] = Html::a('<i class="fas fa-copy"></i> Sao chép ngôn ngữ', ['copy'], ['class' => 'btn btn-success rounded-sm']);

$this->params['vn-navbar'][] = Html::a('<i class="far fa-save"></i> Lưu lại', ['index'], ['class' => 'btn btn-info rounded-sm active_form']);
?>
<div class="contact-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
