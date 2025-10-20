<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TempProduct */

$this->title = 'Update Temp Product: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Temp Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="temp-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
