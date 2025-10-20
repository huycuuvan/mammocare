<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\MyExt;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Chỉnh sửa css giao diện website';
$this->params['breadcrumbs'][] = ['label' => 'Cấu hình website', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="far fa-save"></i> Lưu lại', ['index'], ['class' => 'btn btn-info rounded-sm active_form']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="update-css">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="configure-form">
        <div class="row row-wrapper">
            <div class="col-md-12">

                <div class="white_bg">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12"><?= $form->field($model, 'data')->textArea(['rows' => 30, 'id' => 'code'])->label(false); ?></div>
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
<?php
$this->registerCssFile("@web/codemirror/lib/codemirror.css", ['position' => \yii\web\View::POS_END]);
$this->registerJsFile("@web/codemirror/lib/codemirror.js", ['position' => \yii\web\View::POS_END]);
$this->registerJsFile("@web/codemirror/addon/edit/matchbrackets.js", ['position' => \yii\web\View::POS_END]);
$this->registerJsFile("@web/codemirror/mode/css/css.js", ['position' => \yii\web\View::POS_END]);
$this->registerJs('var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    matchBrackets: true,
    mode: "text/x-scss"
  });', \yii\web\View::POS_END);
?>
