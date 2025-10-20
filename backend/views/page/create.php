<?php
use yii\helpers\Html;
use backend\models\Configure;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */
$edit_mode = Yii::$app->request->get('editor', 0) == 1;
$conf = Configure::getConfigure();

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Trang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="far fa-save"></i> Lưu lại', ['index'], ['class' => 'btn btn-info rounded-sm active_form']);

if (!empty($conf->editorbuilder)) {
    $this->params['vn-navbar'][] = Html::a('<i class="far fa-edit"></i> ' . ($edit_mode ? 'Soạn cơ bản' : 'Soạn nâng cao'), ['create', 'editor' => $edit_mode ? 0 : 1], ['class' => 'btn btn-success rounded-sm switch_form']);
}

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="news-create">
    <?php $form = Yii::$app->request->get('editor', 0) == 1 ? '_form_editor' : '_form'; ?>

    <?= $this->render($form, [
        'model' => $model,
    ]) ?>
</div>
