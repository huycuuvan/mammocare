<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TempProduct */

$this->title = 'Create Temp Product';
$this->params['breadcrumbs'][] = ['label' => 'Temp Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temp-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
