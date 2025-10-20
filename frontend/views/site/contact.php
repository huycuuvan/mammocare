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
    <section class="content contact  py-4 py-lg-5">
        <div class="container">
            <div class="contact-info-box">
                <h5 class="mb-3 text-center1 text-uppercase mx-auto"><?= @$info['contact-page-brief'] ?></h5>
                <p class="mb-4 text-center1  mx-auto1 desc"><?= @$info['contact-page-description'] ?></p>
                <div class="row pd10 align-content-md-stretch text-center">
                    <div class="col-12 col-md-4">
                        <div class="item p-3">
                            <div class="icon mb-0"><i class="fa fa-map-marker-alt "></i></div>
                            <p class="head mb-1 text-uppercase"><?=Yii::t('app','address')?></p>
                            <p class="mb-0 in"><?= $cont->address; ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="item p-3">
                            <div class="icon mb-0"><i class="fa  fa-mobile-alt "></i></div>
                            <p class="head mb-1 text-uppercase"><?=Yii::t('app','phone')?></p>
                            <div class="mb-0 in"><a href="tel:<?=$cont->hotline; ?>"><?=$cont->hotline; ?></a> <br/> <a href="tel:<?=$cont->phone; ?>"><?=$cont->phone; ?></a></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="item p-3">
                            <div class="icon mb-0"><i class="far fa-envelope "></i></div>
                            <p class="head mb-1 text-uppercase"><?=Yii::t('app','email')?></p>
                            <div class="mb-0 in"><a href="mailto:<?=$cont->email; ?>"><?=$cont->email; ?></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row contact-form  mb-3 mt-4 mt-lg-5 align-items-md-center">
                <div class="col-12 col-lg-6  ">
                    <div class="form p-31 border1 p-lg-41 bg_grey1">
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
                            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'enableClientScript' => false, 'enableClientValidation' => false]); ?>
                            <div class="row">
                                <?= $form->field($model, 'name',['options' => ['class' => 'form-group col-12 mb-0 pr1-2']])->textInput(['autofocus' => false, 'placeholder' => Yii::t('app', 'fullname')])->label(false) ?>
                                <?= $form->field($model, 'email',['options' => ['class' => 'form-group col-12 mb-0 pl1-2']])->textInput(['placeholder' => Yii::t('app', 'email')])->label(false); ?>
                                <?= $form->field($model, 'phone',['options' => ['class' => 'form-group col-12 mb-0 pr1-2']])->textInput(['placeholder' => Yii::t('app', 'phone')])->label(false); ?>
                                <?= $form->field($model, 'subject',['options' => ['class' => 'form-group col-12 mb-0 pl1-2']])->textInput(['placeholder' =>  Yii::t('app', 'subject')])->label(false); ?>
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
                <div class="col-12 col-lg-6">
                    <div class="mt-4 mt-lg-0">
                        <div id="mapcont" class="">
                            <?=@$info['map-code']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
