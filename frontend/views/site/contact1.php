<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use backend\models\Seo;
use backend\models\Contact;
use backend\models\Configure;
use yii\widgets\Breadcrumbs;

$seo = Seo::getSeo(Seo::CONTACT_PAGE);
if(!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = Yii::t('app', 'contact');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'contact'), 'url' => ['site/contact']];


$this->registerJsFile('//maps.google.com/maps/api/js?key=' . Yii::$app->params['map-api-key'] . '&language=vi', ['position' => \yii\web\View::POS_END]);
?>
    <section class="content contact  bg_grey py-4">
        <div class="container">

            <div class="row contact-form  mb-3 mt-md-4 align-items-md-center">
                <div class="col-12 col-md-6 col-lg-5 pr-md-5 mb-3 mb-md-0 pr-md-3">
                    <div class=" info p-3 p-lg-4 p-xl-5">
                        <p class="text-uppercase title mb-3"><strong><?=$cont->company_name?></strong></p>
                        <div class="add mb-3 d-flex item">
                            <span class="icon"><i class="fa fa-map-marker-alt "></i></span>
                            <div>
                                <strong class="d-block"><?=Yii::t('app','address')?></strong>
                                <span><?= $cont->address; ?></span>
                            </div>
                        </div>
                        <div class="phone mb-3 item d-flex">
                            <span class="icon"><i class="fa  fa-mobile-alt "></i></span>
                            <div>
                                <strong class="d-block">Hotline</strong>
                                <span><a href="tel:<?=$cont->hotline; ?>"><?=$cont->hotline; ?></a> - <a href="tel:<?=$cont->phone; ?>"><?=$cont->phone; ?></a></span>
                            </div>
                        </div>
                        <div class="email mb-0 item d-flex">
                            <span class="icon"><i class="far fa-envelope "></i></span>
                            <div>
                                <strong class="d-block">Email</strong>
                                <span><a href="mailto:<?=$cont->email; ?>"><?=$cont->email; ?></a></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6 col-lg-7  ">
                    <div class="form">
                        <?php if (Yii::$app->session->hasFlash('contact')): ?>
                            <div class="alert alert-success" role="alert">
                                <?= Yii::$app->session->getFlash('contact'); ?>
                            </div>
                        <?php else: ?>
                            <?php if (Yii::$app->session->hasFlash('contact-error')): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= Yii::$app->session->getFlash('contact-error'); ?>
                                </div>
                            <?php endif;?>
                            <h5 class="mb-4"><?= @$info['contact-description'] ?></h5>
                            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'enableClientScript' => false, 'enableClientValidation' => false]); ?>
                            <div class="row">
                                <?= $form->field($model, 'name',['options' => ['class' => 'form-group col-6 mb-0 pr-2']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'fullname')])->label(false) ?>

                                <?= $form->field($model, 'email',['options' => ['class' => 'form-group col-6 mb-0 pl-2']])->textInput(['placeholder' => Yii::t('app', 'email')])->label(false); ?>

                                <?= $form->field($model, 'phone',['options' => ['class' => 'form-group col-6 mb-0 pr-2']])->textInput(['placeholder' => Yii::t('app', 'phone')])->label(false); ?>

                                <?= $form->field($model, 'subject',['options' => ['class' => 'form-group col-6 mb-0 pl-2']])->textInput(['placeholder' =>  Yii::t('app', 'subject')])->label(false); ?>

                                <?= $form->field($model, 'body',['options' => ['class' => 'form-group col-12 mb-0']])->textarea(['rows' => 6, 'placeholder' => Yii::t('app', 'message')])->label(false); ?>
                                <div class="form-group col-12 mb-0">
                                    <?= Html::submitButton(Yii::t('app','send'), ['class' => 'btn btn-submit mb-0']) ?>
                                    <!--                            --><?//= Html::resetButton(Yii::t('app', 'reset'), ['class' => 'btn btn-reset']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="mt-4 mt-lg-5">
                <div id="mapcont" class="mb-3"></div>
            </div>

        </div>
    </section>


<?php
$contentMap = '<div id="map-info-window">' .
    "<div><h2>{$cont->company_name}</h2>" .
    "<p><strong>" . Yii::t('app', 'address') . ":</strong> " . trim(preg_replace('/\s\s+/', ' ', $cont->address)) . "</p>" .
    "<p><strong>" . Yii::t('app', 'tel') . ":</strong> {$cont->phone} </p>" .
    "<p><strong>" . Yii::t('app', 'hotline') . ":</strong> {$cont->hotline} </p>" .
    "<p><strong>" . Yii::t('app', 'email') .": </strong> <a href=\"mailto:{$cont->email}\">{$cont->email}</a></p>" .
    '</div>';

$script = <<< JS
  var infoWindow;


  var toa_do = new google.maps.LatLng({$cont->map});
  var conf = {
      center: toa_do,
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      disableDefaultUI: true,
      mapTypeControl: true,
      navigationControl: true,
      navigationControlOptions: {
          style: google.maps.NavigationControlStyle.SMALL
      }
  }
  map = new google.maps.Map(document.getElementById('mapcont'),conf);

  var marker = new google.maps.Marker({
      position: toa_do,
      map: map,
      title: '{$cont->company_name}',
  });

  google.maps.event.addListener(marker, 'click', function() {
      if(!infoWindow)
      {
          infoWindow = new google.maps.InfoWindow();
      }
      var content = '{$contentMap}';
      infoWindow.setContent(content);
      infoWindow.open(map, marker);
  });

JS;

$this->registerJs($script);

