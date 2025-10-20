<?php
use backend\models\Partner;
use backend\models\Cat;
use backend\models\CatDoctor;
use backend\models\CatProject;
use backend\models\Supporter;
use backend\models\Link;
use backend\models\Menu;
use backend\models\News;
use backend\models\Info;
use backend\models\Province;
use backend\models\Tab;
use backend\models\Place;
use backend\models\Ward;
use backend\models\Project;
use backend\models\District;
use backend\models\Property;
use backend\models\PropertyValue;
use backend\components\MyExt;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use frontend\models\SubscribeForm;
$cat_id=0;
$province_id=0;
$district_id=0;
$ward_id=0;
$project_id=0;
$acreage_id=0;
$price_id=0;
$type_id=0;
$category_id=0;
$direct_id=0;
if(isset( $_GET['i'])){
    $chuoi= explode('-',base64_decode( $_GET['i']));
//var_dump($chuoi) ;
//    $cat_id=$chuoi[0];
//    $province_id=$chuoi[1];
//    $district_id=$chuoi[2];
}
//var_dump($acreage_id);
//var_dump($price_id);
//echo $cat_id;
$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';
$info= Tab::getTabs();
?>
<section class="search-desktop search-page ">
    <div class="container">
        <div class="search-wrap">
            <?= Html::beginForm(['site/book-doctor2'], 'GET', ['class' => 'search_form']); ?>
            <div class="">
                <div class="two ">
                    <div class="row no-gutters">
                        <div class="col-12 col-md-6 col-lg-3 input-box select-box p-3 has-icon1 border-right mb-2 mb-md-0">
                            <p class="text mb-0"><?= Yii::t('app', 'fullname') ?></p>                            
                            <div class="form-group mb-0 field-bookform-name ">
                                <input type="text" id="book-form-name" class="form-control" name="bookForm[name]"  aria-required="true">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 input-box select-box p-3 has-icon1 border-right mb-2 mb-md-0">
                            <p class="text mb-0"><?= Yii::t('app', 'phone') ?></p>                            
                            <div class="form-group mb-0 field-bookform-phone ">
                                <input type="text" id="book-form-phone" class="form-control" name="bookForm[phone]"  aria-required="true">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3 select-box p-3 has-icon mb-2 mb-md-0">
                            <p class="text mb-0"><?= $info['book-date'] ?></p>
                            <div class="form-group  mb-0 wrapper-select">
                                <input type="text" id="book-select-date" class="form-control" name="start_datetime" placeholder="Ngày giờ đến">
                                <span class="icon"><i class="far fa-calendar-alt"></i></span>
                            </div>
                        </div>
                        <div class="col-12  col-md-6 button-box col-lg-3">
                            <button class="submit" id="book-submit-button" type="button"><span><?=@$info['book-button']?></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>
</section>