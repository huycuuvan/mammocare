<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Task;
use yii\helpers\ArrayHelper;

$task_filter = ArrayHelper::map(Task::find()->where(['parent' => 0])->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name');

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="task-form">
    <div class="row row-wrapper">
        <div class="col-md-6">

            <div class="white_bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'tblname')->textInput(['maxlength' => true]); ?>
                        </div>

                        <div class="col-6">
                            <?= $form->field($model, 'parent')->dropDownList($task_filter, ['prompt' => 'Vui lòng chọn...']); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'note')->textArea(['rows' => 5]); ?></div>
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
