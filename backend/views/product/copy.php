<?php
use yii\helpers\Html;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Sao chép sản phẩm';
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$languageList = Language::getLanguageDDL();
?>

<div class="tab-form">
    <div class="row row-wrapper">
        <div class="col-md-8">

            <div class="white_bg">
                <div class="container-fluid">
                  <?php if (Yii::$app->session->hasFlash('copy')): ?>
                  <div class="alert alert-success" role="alert">
                    <?= Yii::$app->session->getFlash('copy'); ?>
                  </div>
                  <?php else: ?>
                  <?= Html::beginForm(['product/copy', 'id' => $id], 'post', []) ?>

                    <div class="row">

                      <div class="col-12 <?= count($languageList) < 2 ? 'd-none' : '' ?>">
                        <div class="form-group">
                          <label>Ngôn ngữ đích</label>
                          <?= Html::dropDownList('copy-target', '', $languageList, ['class' => 'form-control']); ?>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label>Số lượng sản phẩm nhân bản</label>
                          <?= Html::input('number', 'copy-number', '1', ['class' => 'form-control']); ?>
                        </div>
                      </div>

                      <?= Html::hiddenInput('id', $id); ?>

                      <div class="col-12 text-right">
                        <div class="form-group">
                          <?= Html::submitButton('<i class="far fa-copy"></i> Sao chép', ['class' => 'btn btn-info rounded-sm']) ?>
                        </div>
                      </div>
                    </div>
                  <?= Html::endForm() ?>
                  <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</div>
