<?php
use yii\helpers\Html;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Cat */

$this->title = 'Sao chép ngôn ngữ';
$this->params['breadcrumbs'][] = ['label' => 'Tab ngắn', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
                  <?= Html::beginForm(['tab/copy'], 'post', []) ?>

                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label>Ngôn ngữ nguồn</label>
                          <?= Html::dropDownList('copy-source', '', Language::getLanguageDDL(), ['class' => 'form-control']); ?>
                        </div>
                      </div>

                      <div class="col-12">
                        <div class="form-group">
                          <label>Ngôn ngữ đích</label>
                          <?= Html::dropDownList('copy-target', '', Language::getLanguageDDL(), ['class' => 'form-control']); ?>
                        </div>
                      </div>

                      <div class="col-12 text-right">
                        <div class="form-group">
                          <?= Html::submitButton('<i class="far fa-save"></i> Sao chép', ['class' => 'btn btn-info rounded-sm']) ?>
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
