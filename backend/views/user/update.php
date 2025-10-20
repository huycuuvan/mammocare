<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Cập nhật';
$this->params['breadcrumbs'][] = ['label' => 'Tài khoản', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>
<div class="user-update">

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  <div class="user-form">
      <div class="row row-wrapper">
          <div class="col-md-8">

            <?=$form->errorSummary($model); ?>

              <div class="white_bg">
                  <div class="container-fluid">

                      <div class="row">
                          <div class="col-12"><?= $form->field($model, 'username')->textInput(['maxlength' => true]); ?></div>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                          <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]); ?>
                          </div>

                          <div class="col-md-6">
                          <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]); ?>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                              <?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
                          </div>

                          <div class="col-md-6">
                              <?= $form->field($model, 'address')->textInput(['maxlength' => true]); ?>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">  
                            <?= $form->field($model, 'store')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'address_number')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'ico')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'dic')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'psc')->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-6">  
                            <?= $form->field($model, 'note')->textArea(['maxlength' => true, 'rows' => 3]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'roles_id')->dropDownList($model->getCreatedRolesDDL(), ['prompt' => 'Vui lòng chọn...']); ?>
                        </div>

                        <div class="col-md-6">
                            <p style="margin-top: 30px;"><?= $form->field($model, 'active')->checkBox() ?></p>
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
