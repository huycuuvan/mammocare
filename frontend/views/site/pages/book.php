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
use backend\models\Partner;
use backend\models\CatDoctor;
use backend\models\Supporter;
use yii\widgets\Breadcrumbs;
use backend\components\MyExt;
$seo = Seo::getSeo(Seo::APP_PAGE);
if(!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = Yii::t('app', 'contact');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'contact'), 'url' => ['site/book-doctor','i'=>isset($_GET['i'])?$_GET['i']:'']];
$cat_id=0;
$doctor_id=0;
if(isset( $_GET['i'])){
    $chuoi= explode('/',base64_decode( $_GET['i']));
    $cat_id=$chuoi[0];
    $doctor_id=$chuoi[1];
}
?>
    <section class="content contact booking bg_grey py-4">
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
                            <h5 class="mb-4"><?= @$info['book-description'] ?></h5>
                            <?php $form = ActiveForm::begin(['id' => 'contact-form', 'enableClientScript' => false, 'enableClientValidation' => false]); ?>
                            <div class="row pd8">
                                <?= $form->field($model, 'name',['options' => ['class' => 'form-group col-6 mb-0 ']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'fullname')])->label(true) ?>
                                <?= $form->field($model, 'phone',['options' => ['class' => 'form-group col-6 mb-0 ']])->textInput(['placeholder' => Yii::t('app', 'phone')])->label(true); ?>
                                <?= $form->field($model, 'date',['options' => ['class' => 'form-group col-6 mb-0 ']])->textInput(['placeholder' => 'Ngày khám','id'=>'book-select-date'])->label(true); ?>
                                <?= $form->field($model, 'body',['options' => ['class' => 'form-group col-12 mb-0']])->textarea(['rows' => 4, 'placeholder' => Yii::t('app', 'message')])->label(false); ?>
                                <div class="form-group col-12 mb-0">
                                    <?= Html::submitButton(Yii::t('app','send'), ['class' => 'btn btn-submit mb-0']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
//dịch vụ
$linkList = Partner::getPartner(Partner::CERTI);
if(!empty($linkList)){
    $style='';
    $anh=@$info['link-background']['path'];
    $style="background-image:url( '".$anh."');";
    ?>
    <section class="link-home pt-4 pt-lg-5 pb-5" style="<?= $style ?>">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <p class="mb-2 title" ><?= @$info['link-title'] ?> </p>
                <p class="mb-0 brief" ><?= @$info['link-brief'] ?></p>
            </div>
            <div class="wrap pb-5">
                <div class="owl-carousel owl-theme owl-link">
                    <?php
                    foreach ($linkList as $key => $row){
                        ?>
                        <div class="item-wrap" data-aos="fade-up" data-aos-delay="<?=($key+1)*100?>">
                            <div class="item" onclick="location.href='<?= $row->url ?>';">
                                <div class="img-box d-flex">
                                    <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->name; ?>">
                                </div>
                                <div class="info-box py-3 px-2 px-lg-3 text-center">
                                    <p class="mb-2 name "><?=strip_tags($row->name)?></p>
                                    <p class="mb-2 info"><?=strip_tags($row->content)?></p>
                                    <div class="text-center"><a class="more" href="<?=$row->url?>"><?=Yii::t('app','more2')?></a></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
//đội ngũ bác sĩ
$doctorList = Supporter::getSupportHome();
if(!empty($doctorList)){
    ?>
    <section class="py-4 py-lg-5 doctor-home"   >
        <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
            <p class="mb-2 title" ><?= @$info['doctor-title'] ?> </p>
            <p class="mb-0 brief" ><?= @$info['doctor-brief'] ?></p>
        </div>
        <div class="wrap pb-5"  data-aos="fade-up" data-aos-delay="200">
            <div class="owl-carousel owl-theme owl-doctor-style ">
                <?php
                $i=1;
                foreach($doctorList as $row):
                    $open_div='';
                    if(($i==1 || MyExt::chuoisocong($i,1,5) == 1 ) ) $open_div='<div class="wrap-box d-md-flex '.$i.'">';
                    echo $open_div;
                    ?>
                    <div class="item-wrap <?php if(($i==1 || MyExt::chuoisocong($i,1,5) == 1 ) ) echo 'full-width'?>">
                        <div class="item text-center">
                            <div class="img-box d-flex"  onclick="location.href='<?=$row->getUrl()?>';">
                                <img class="lazyload img-cover" data-src="<?= $row->path?$row->path:'upload/no-image.jpg'?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" />
                            </div>
                            <div class="info-box mt-3 mb-2">
                                <p class="specialist mb-1"><?= $row->father?$row->father->name:''?></p>
                                <a class="name text-gradient mb-1 text-uppercase" href="<?=$row->getUrl()?>"><?=$row->name?></a>
                                <p class="brief text-gradient mb-2"><?=$row->brief?></p>
                                <p class="info mb-2 "><?=$row->content?></p>
                                <a class="email pt-1 border-top" href="mailto:<?=$row->email?>"><i class="far fa-envelope"></i> <?=$row->email?></a>
                                <a class="phone" href="tel:<?=$row->mobile?>"><i class="fas fa-phone-alt"></i> <?=$row->mobile?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $close_div='';
                    if($i==5 || MyExt::chuoisocong($i,5,5) == 1) $close_div='</div>';
                    echo $close_div;
                    $i++;
                endforeach;
                if(count($doctorList)%5!=0) echo '</div>';
                ?>
            </div>
        </div>
    </section>
    <?php
}
?>
