<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CatProduct */

$this->title = 'Create Cat Product';
$this->params['breadcrumbs'][] = ['label' => 'Cat Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
