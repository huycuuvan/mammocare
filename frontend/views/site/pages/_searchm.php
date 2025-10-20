<?php
use backend\models\Partner;
use backend\models\Cat;
use backend\models\CatNews;
use backend\models\CatProject;
use backend\models\Product;
use backend\models\Link;
use backend\models\Menu;
use backend\models\Place;
use backend\models\Info;
use backend\models\Province;
use backend\models\Tab;
use backend\models\City;
use backend\models\Supporter;
use backend\models\Seo;
use backend\models\Project;
use backend\models\District;
use backend\models\Ward;
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
    $cat_id=$chuoi[0];
    $province_id=$chuoi[1];
    $district_id=$chuoi[2];
    $ward_id=$chuoi[3];
    $project_id=$chuoi[4];
    $acreage_id=$chuoi[5];
    $price_id=$chuoi[6];
    $direct_id=$chuoi[7];

    $model = Cat::findOne($cat_id);
    $category_id=$model->id;
    $type_id=0;
    if($model->parent!=0){
        $category_id=$model->parent;
        if($model->father->parent!=0)
            $category_id=$model->father->parent;
        $type_id=$cat_id;
    }
}
//echo $cat_id;
$keyword=isset($_GET['keyword'])?$_GET['keyword']:'';

$info= Tab::getTabs();
?>
<div class="search-mobile search-page p-2">
    <div class="search-wrap">
        <?= Html::beginForm(['site/search-news'], 'GET', ['class' => 'search_form']); ?>
        <div>
            <div class="one row no-gutters ">
                <input type="text" class="txtkeyword search_keyword mb-3" name="keyword" placeholder="<?= Yii::t('app', 'keyword') ?>..." value="<?=isset($_GET['keyword'])?$_GET['keyword']:''?>" autocomplete="off">
            </div>
            <div class="two">
                <div class="row pd10">
                    <div class="col-12 has-icon mb-3">
                        <div class="form-group  mb-0 wrapper-select">
                            <input type="text" id="search-start-datetime" class="form-control" name="start_datetime" placeholder="Ngày giờ đến">
                            <span class="icon"><i class="far fa-calendar-alt"></i></span>
                            <span class="icon2"><i class="fas fa-caret-down"></i></span>
                        </div>
                    </div>
                    <div class="col-12 has-icon mb-3">
                        <div class="form-group  mb-0 wrapper-select">
                            <input type="text" id="search-end-datetime" class="form-control" name="end_datetime" placeholder="Ngày giờ đi" disabled>
                            <span class="icon"><i class="far fa-calendar-alt"></i></span>
                            <span class="icon2"><i class="fas fa-caret-down"></i></span>
                        </div>
                    </div>
                    <div class="col-12 has-icon mb-3">
                        <div class="form-group  mb-0 wrapper-select province field-product-province_id ">
                            <?php
                            $selected=$province_id;
                            ?>
                            <select id="search-place-id" data-content="Địa điểm" class="addtoselect form-control" name="province_id" aria-="true">
                                <option value="">Địa điểm</option>
                                <?=Place::getPlaceoption($selected);?>
                            </select>
                            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                        </div>
                    </div>
                    <div class="col-12 has-icon mb-3">
                        <div class="form-group  mb-0 wrapper-select province field-product-province_id ">
                            <?php
                            $selected=$province_id;
                            ?>
                            <select id="search-price-id" data-content="Khoảng giá" class="addtoselect form-control" name="price_id" aria-="true">
                                <option value="">Khoảng giá</option>
                                <?=PropertyValue::getPriceoption($selected);?>
                            </select>
                            <span class="icon"><i class="fas fa-dollar-sign"></i></span>
                        </div>
                    </div>
                    <div class="col-12 has-icon mb-3">
                        <div class="form-group  mb-0 wrapper-select province field-product-province_id ">
                            <?php
                            $selected=$province_id;
                            ?>
                            <select id="search-cat-id" data-content="Loại hình" class="addtoselect form-control" name="cat_id" aria-="true">
                                <option value="">Loại hình</option>
                                <?=Cat::getCatoption($selected);?>
                            </select>
                            <span class="icon"><i class="far fa-building"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tree ">
                <div>
                    <button class="submit" type="button"><span>Tìm kiếm <i class="fas fa-search"></i></span></button>

                </div>
            </div>
        </div>

        <?= Html::endForm(); ?>
    </div>
</div>