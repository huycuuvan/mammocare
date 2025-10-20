<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Roles;
use backend\models\Task;
use yii\helpers\ArrayHelper;

$role_filter = ArrayHelper::map(Roles::find()->where(['active' => 1])->asArray()->all(), 'id', 'name');

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<?=$form->errorSummary($model); ?>
<div class="task-form">
    <div class="row row-wrapper">
        <div class="col-md-8">

            <div class="white_bg">
                <div class="container-fluid listtask-vina">

                    <h2>Thiết lập quyền quản lý</h2>
                    <?php
                    $task = Task::getTask();
                    if (!empty($task)) {
                        foreach ($task as $row) {
                            $actions = $row->child;
                            if (!empty($actions)) {
                                ?>
                                <div class="list-lv">
                                    <h3>Quản lý <?=$row->name; ?> <a href="#" class="all-task">[Chọn tất cả]</a> <a href="#" class="none-task">[Bỏ tất cả]</a></h3>
                                    <div class="row">
                                        <?php
                                        foreach ($actions as $item) {
                                            ?>
                                            <div class="col-3">
                                                <label><?=Html::checkbox('task_ids[]', $model->checked($item->id), ['value' => $item->id]); ?> <?=$item->name; ?></label>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>


                </div>
            </div>

        </div>


        <div class="col-md-4">

            <div class="white_bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'roles_list', ['enableClientValidation' => false])->dropDownList($role_filter, [
                            'prompt' => 'Vui lòng chọn...',
                            'multiple' => true
                            ]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'active')->checkBox() ?></div>
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
