<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\components\MyExt;
use backend\models\CatNews;
use backend\models\News;
use backend\models\Product;
use frontend\models\SubscribeForm;
use yii\bootstrap\ActiveForm;

$model = new SubscribeForm;
?>


<!-- Modal -->
<div class="modal fade" id="supportmodal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-subscribe" role="document">
    <div class="modal-content">
      <?php $form = ActiveForm::begin(['action' => Url::toRoute('site/subscribe'), 'id' => 'subscribe-form', 'enableClientScript' => false, 'enableClientValidation' => false]); ?>

      <div class="modal-header">
        <h5 class="title"><?= Yii::t('app', 'support-title') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <?= $form->field($model, 'name')->textInput(['placeholder' => Yii::t('app', 'fullname'), 'id' =>  'name']) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'email'), 'id' =>  'email']); ?>

        <?= $form->field($model, 'phone')->textInput(['placeholder' => Yii::t('app', 'phone'), 'id' =>  'phone']); ?>

        <?= $form->field($model, 'body')->textarea(['rows' => 3, 'placeholder' => Yii::t('app', 'message'), 'id' =>  'message']); ?>

      </div>
      <div class="modal-footer">
        <?= Html::submitButton(Yii::t('app', 'support-button'), ['class' => 'btn btn-success']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
