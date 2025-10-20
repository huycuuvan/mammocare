<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\CatNews;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Import';
$this->params['breadcrumbs'][] = ['label' => 'Tỉnh thành', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="far fa-save"></i> Lưu lại', ['index'], ['class' => 'btn btn-info rounded-sm active_form']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="news-update">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="news-form">
        <div class="row row-wrapper">
            <div class="col-lg-12">
                <div class="white_bg vina-right" style="padding-bottom: 0;">
                    <div class="container-fluid">

                        <strong class="title_box">Tệp tin đính kèm</strong>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <?= $form->field($model, 'file')->fileInput()->label(false); ?>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="text-right">
            <?= Html::submitButton('<i class="far fa-save"></i> Lưu lại', ['class' => 'btn btn-info rounded-sm']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

