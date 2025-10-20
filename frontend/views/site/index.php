<?php
use backend\models\Partner;
use backend\models\Cat;
use backend\models\CatNews;
use backend\models\Product;
use backend\models\Link;
use backend\models\News;
use backend\models\Comment;
use backend\models\Album;
use backend\models\Tab;
use backend\models\CatDoctor;
use backend\models\Supporter;
use backend\models\Seo;
use backend\models\Booking;
use backend\models\Video;
use backend\models\CatProfile;
use backend\models\Profile;
use backend\components\MyExt;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use frontend\models\SubscribeForm;
/* @var $this yii\web\View */
$seo = Seo::getSeo(Seo::HOME_PAGE);
$this->registerJsFile('//maps.google.com/maps/api/js?key=' . Yii::$app->params['map-api-key'] . '&language=vi', ['position' => \yii\web\View::POS_END]);
if (!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = $cont->site_title;
    Yii::$app->params['og_description'] = $cont->site_desc;
}
?>
<?php
if (MyExt::mobileDetect()) :
    $slidemb = Partner::getPartner(Partner::SLIDE_MOBILE);
    if (!empty($slidemb)) :
        $sl_video=$slidemb[0];
        if($sl_video->path_file!='' && file_exists($sl_video->path_file)){
            ?>
            <section class="slider-video-mb">
                <iframe src="<?=$sl_video->path_file?>" type="video/mp4" allow="autoplay" id="video" style="display:none"></iframe>
                <video class="video" loop muted autoplay>
                    <source src="<?=$sl_video->path_file?>" type="video/mp4">
                </video>
            </section>
            <?php
        }
        else{
            ?>
            <section class="slider d-lg-none">
                <div class="owl-carousel owl-theme owl-slider-mobile">
                    <?php foreach ($slidemb as $row) : ?>
                        <div class="item">
                            <a href="<?= $row->url ?>">
                                <img src="<?= $row->path ?>"  alt="<?= $row->name ?>" />
                            </a>
                            <?php if($row->content!=""){?>
                                <div class="d-none">
                                    <div class="container my-auto">
                                        <div class="wrap p-4 text-center">
                                            <div class="title_sl mb-3 text-uppercase mt-2 work"><span class="text"><?=$row->name?></span> <span class="gradient"><?=$row->name?></span></div>
                                            <div class="brief_sl mb-3 mb-lg-5"><?=strip_tags($row->content)?></div>
                                            <div class="more_sl d-none">
                                                <a class=" d-inline-block px-3 px-lg-4 px-xl-5 mt-lg-3" href="<?=$row->url?>"><?=Yii::t('app','more1')?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php
        }
    endif;
else :
    $slide = Partner::getPartner(Partner::SLIDE);
    if (!empty($slide)) :
        $sl_video=$slide[0];
        if($sl_video->path_file!='' && file_exists($sl_video->path_file)){
            ?>
            <section class="slider-video">
                <video class="video" loop muted autoplay>
                    <source src="<?=$sl_video->path_file?>" type="video/mp4">
                </video>
                <?php if($sl_video->content!=""){?>
                    <div class="d-flex slider-content">
                        <div class="container my-auto">
                            <div class="wrap text-center mx-auto">
                                <div class="title_sl mb-3 text-uppercase mt-2 work mx-auto"><span class="text"><?=$sl_video->name?></span></div>
                                <div class="brief_sl mb-4 mx-auto"><?=strip_tags($sl_video->content)?></div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </section>
            <?php
        }
        else{
            ?>
            <!-- begin slider_box -->
            <section class="slider slider-adv ">
                <div class="owl-carousel owl-theme owl-slider">
                    <?php $i=0;
                    foreach ($slide as $row) {
                        ?>
                        <div class="item">
                            <a href="<?=$row->url?>"><img class="lazyload" src="<?=$row->path?>" alt="<?=$row->name?>"/> </a>
                            <?php if($row->content!=""){?>
                                <div class="d-flex">
                                    <div class="container my-auto px-0">
                                        <div class="wrap  text-center">
                                            <div class="title_sl mb-2 text-uppercase  work mx-auto"><?=$row->name?></div>
                                            <div class="info_sl mb-3 d-inline-block mx-auto"><?=strip_tags($row->info2)?></div>
                                            <div class="brief_sl mb-4 mx-auto"><?=strip_tags($row->content)?></div>
                                            <div class="more_sl d-none">
                                                <a class="btn1 d-inline-block px-3 px-lg-4  mt-lg-3" href="<?= @$info['slide-button-url-1']?>"><?= @$info['slide-button-title-1']?> <i class="fas fa-arrow-right"></i></a>
                                                <a class="btn2 d-inline-block px-3 px-lg-4  mt-lg-3" href="<?= @$info['slide-button-url-2']?>"><?= @$info['slide-button-title-2']?> <i class="fas fa-arrow-right"></i></a>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                            <img class="img-sl img-top d-none" alt="<?=$row->name?> top d-none" src="bundle/css/images/stop.png"/>
                            <img class="img-sl img-right d-none" alt="<?=$row->name?> right d-none" src="bundle/css/images/sright.png"/>
                            <img class="img-sl img-bottom d-none" alt="<?=$row->name?> bottom d-none" src="bundle/css/images/sbot.png"/>
                            <img class="img-sl img-left d-none" alt="<?=$row->name?> left d-none" src="bundle/css/images/sleft.png"/>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
            </section>
            <!-- end slider_box -->
            <?php
            echo Yii::$app->controller->renderPartial('pages/_search');
        }
    endif;
endif;
?>
<?php
$aboutList = Partner::getPartner(Partner::ABOUTUS,1);
$aboutSign = Partner::getPartner(Partner::ABOUTLINK,1);
if(!empty($aboutList)){
    $ab=$aboutList[0];
    ?>
    <section class=" about-home" style="background-image: url(<?= $ab->background ?>); ">
        <div class="row no-gutter">
            <div class="col-12 col-md-7 " data-aos="fade-right" data-aos-delay="100">
                <div class=" about-content px-3 px-lg-0 mb-4 mb-lg-0 d-md-flex py-4 py-lg-5">
                    <div class="wap  my-auto">
                        <p class="info mb-0 pt-lg-5"><?= $ab->name; ?></p>
                        <div class="name  mb-3"><?= $ab->info; ?></div>
                        <div class="mb-0 brief"><?= $ab->content ?></div>
                        <?php
                        if(!empty($aboutSign)){
                            $row=$aboutSign[0];
                            ?>
                            <div class="about-sign d-flex pl-lg-4 pl-xl-5 mt-3 mt-lg-4 align-items-end">
                                <div class="img-box d-flex"><img alt="<?=$row->name?>" src="<?=$row->path?>" class="img-cover"></div>
                                <div class="inf ml-2">
                                    <div class="d-flex align-items-end">
                                        <span class="mb-0"><?=$row->name?></span>
                                        <img alt="<?=$row->name?> 1" src="<?=$row->background?>" class="">
                                    </div>
                                    <p class="s-name text-uppercase text-gradient mb-0"><?=$row->info2?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5" data-aos="fade-left" data-aos-delay="100">
                <div class="d-md-flex wrap-img">
                    <div class="service-image-box my-auto">
                        <div class="img-box d-flex">
                            <img class="img-cover" src="<?= $ab->path; ?>" alt="<?= $ab->name; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php
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
<?php } ?>
<?php 
//Cơ sở vật chất
// $serviceList = CatDoctor::getHomeParent();
$serviceList = Partner::getPartner(Partner::SERVICE);
if(!empty($serviceList)){
    ?>
    <section class="service-home pt-4 pt-lg-5 pb-5" >
        <div class="container1">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <p class="mb-1 title   utm" ><?= @$info['service-title'] ?> </p>
                <p class="mb-0 brief  " ><?= @$info['service-brief'] ?></p>
            </div>
            <div class="wrap pb-5">
                <div class="owl-carousel owl-theme owl-our">
                    <?php
                    foreach ($serviceList as $key => $row){
                        ?>
                        <div class="item-wrap" data-aos="fade-up" data-aos-delay="<?=($key+1)*100?>">
                            <div class="item" onclick="location.href='<?= $row->url ?>';">
                                <div class="img-box d-flex">
                                    <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->name; ?>">
                                </div>
                                <div class="info-box py-1 px-2 px-lg-3 text-center">
                                    <p class="mb-0 mt-2 name"><?=strip_tags($row->name)?></p>
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
<?php } ?>
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
                                    <div class="text-center"><a class="more" href="<?=$row->url?>"><?=Yii::t('app','more4')?></a></div>
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
<?php } ?>
<?php 
//Tư vấn
$adviseList = Partner::getPartner(Partner::COMMIT);
$instructList = Partner::getPartner(Partner::CONTACT);
if(!empty($adviseList) && !empty($instructList)) {
    ?>
    <section class="advise-home py-4 py-md-5" >
        <div class="container">
            <div class="row">
                <?php if(!empty($adviseList)) { ?>
                    <div class="advise-left col-12 col-md-6">
                        <div class="row pd10 advise-list">
                            <?php foreach ($adviseList as $key => $row){
                                ?>
                                <div class="item-wrap col-12 col-md-6 mb-3 mb-md-0" data-aos="fade-up" data-aos-delay="<?=($key+1)*100?>">
                                    <div class="item p-3" onclick="location.href='<?= $row->url ?>';">
                                        <div class="img-box d-flex">
                                            <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->name; ?>">
                                        </div>
                                        <div class="info-box mt-2">
                                            <h3 class="name mb-2"><?=strip_tags($row->name)?></h3>
                                            <div class="brief">
                                                <?=strip_tags($row->content)?>
                                                <i class="fas fa-arrow-circle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if(!empty($instructList)) { ?>
                    <div class="instruct-right col-12 col-md-6 ">
                        <div class="instruct-wrap p-3 p-md-4">
                            <h3 class="title mb-3 mb-md-4"><?= @$info['instruct-title'] ?></h3>
                            <div  id="accordion"  class="instruct-list">
                                <?php foreach ($instructList as $key => $row){
                                    ?>
                                    <div class="card" data-aos="fade-up" data-aos-delay="<?=($key+1)*100?>">
                                        <div class="card-header" id="heading<?= $row->id; ?>">
                                            <h5 class="mb-0">
                                                <button class="d-flex btn btn-link <?=($key!=0)?'':'collapsed';?>" data-toggle="collapse" data-target="#collapse<?= $row->id; ?>" aria-expanded="true" aria-controls="collapse<?= $row->id; ?>">
                                                    <?= $row->name; ?>
                                                    <div class="right">
                                                        <i class="fas fa-plus-circle"></i>
                                                        <i class="fas fa-minus-circle"></i>
                                                    </div>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapse<?= $row->id; ?>" class="collapse <?=($key==0)?'show':'';?>" aria-labelledby="heading<?= $row->id; ?>" data-parent="#accordion">
                                            <div class="card-body">
                                                <?=strip_tags($row->content)?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="viewmore d-flex mt-3 mt-md-4">
                                <a href="<?= @$info['instruct-url'] ?>" class="more"><?=Yii::t('app','more5')?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
<?php 
//thủ viện ảnh
$galleryList = Partner::getPartner(Partner::WHY);
if(!empty($galleryList)){
    $dem=0;
    ?>
    <section class="pt-4 pt-lg-5 pb-41 gallery-home">
        <div class="container1">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <p class="mb-2 title" ><?= @$info['gallery-title'] ?> </p>
                <p class="mb-0 brief" ><?= @$info['gallery-brief'] ?></p>
            </div>
            <div class="link-wrap owl-carousel owl-theme owl-gallery-home pt-1 pt-lg-3">
                <?php
                $i=1;
                foreach ($galleryList as $key=>$row) :
                    $url = '#';
                    $open_div='';
                    if(($i==1 || MyExt::chuoisocong($i,1,3) == 1 ) && $i%2!=0) $open_div='<div class="wrap-box '.$i.'"><div class="wrap "> ';
                    elseif(($i==1 || MyExt::chuoisocong($i,1,3) == 1 ) && $i%2==0) $open_div='<div class="wrap-box '.$i.'"><div class="wrap even"> ';
                    echo $open_div;
                    if($i==1 || MyExt::chuoisocong($i,1,6) == 1) $class='col1';
                    if($i==2 || MyExt::chuoisocong($i,2,6) == 1) $class='col2';
                    if($i==3 || MyExt::chuoisocong($i,3,6) == 1) $class='col3 ';
                    if($i==4 || MyExt::chuoisocong($i,4,6) == 1) $class='col3 ';
                    if($i==5 || MyExt::chuoisocong($i,5,6) == 1) $class='col2';
                    if($i==6 || MyExt::chuoisocong($i,6,6) == 1) $class='col1';
                    $check=0;
                    if($row->info2==''){
                        $imgPath=$row->path;
                    }
                    else{
                        $imgPath='https://www.youtube.com/watch?v='.$row->info2;
                        $check++;
                    }
                    ?>
                    <div class="item-wrap <?=$class?>">
                        <div class="item" data-aos="fade-left" data-aos-delay="<?=($key+1)*100?>">
                            <div class="box" >
                                <a data-fancybox="gallery" class="<?=$check>0?'has-video':''?> img-box d-flex" href="<?= $imgPath ?>">
                                    <img class="m-auto img-cover" src="<?= $row->path ?>" alt="<?= $row->name ?>" >
                                    <span class="see-more text-uppercase <?=$check>0?'d-none':''?>"><i class="fas fa-plus"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $close_div='';
                    if($i==3 || MyExt::chuoisocong($i,3,3) == 1) $close_div='</div></div>';
                    echo $close_div;
                    $i++;
                    $dem++;
                endforeach;
                if((count($galleryList)%3)!=0) echo '</div></div>'
                ?>
            </div>
        </div>
    </section>
    <?php
}
//Tin tức
$news = News::getHomeNews();
if (!empty($news)) {
    ?>
    <section class="home_news py-4 py-lg-5">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <p class="mb-2 title" ><?= @$info['news-title'] ?> </p>
                <p class="mb-0 brief" ><?= @$info['news-brief'] ?></p>
            </div>
            <div class="wrap">
                <div class="list_home_news owl-carousel owl-theme owl-news pt-1 ">
                    <?php
                    $i=1;
                    foreach ($news as $row){
                        $cat_home=CatNews::findOne($row->cat_id);
                        $url = $row->getUrl();
                        $urlCat = $cat_home->getUrl();
                        ?>
                        <div class="w-item"  data-aos-delay="<?= $i * 100 ?>" data-aos="fade-left">
                            <div class="item">
                                <div class="img-box mb-0">
                                    <div class="image_inner">
                                        <span class="d-flex"><img class="lazyload img-cover" data-src="<?= $row->path ?>" alt="<?= $row->title ?>"></span>
                                        <div class="overlay">
                                            <div class="icon_position_table">
                                                <div class="icon_container">
                                                    <a href="<?= $url ?>" class="border_round"><i class="fas fa-link"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-body p-3">
                                    <h5 class="">
                                        <a class="item-title mb-2" href="<?= $url ?>"><?= $row->title ?></a>
                                    </h5>
                                    <p class="content mb-2"><?=strip_tags($row->brief)?></p>
                                    <div class="d-flex justify-content-between align-items-center more-wrap">
                                        <a class="text-uppercase " href="<?= $url ?>">XEM THÊM</a>
                                        <span class="date"><?=date('d-m-Y',strtotime($row->created_at))?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>
<?php
//Comment
$commentList = Comment::getComment();
if (!empty($commentList)) {
?>
    <section class="customer-home py-4 py-lg-5 ">
        <div class="container" data-aos="flip-left" data-aos-delay="100">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <p class="mb-2 title" ><?= @$info['customer-title'] ?> </p>
                <p class="mb-0 brief" ><?= @$info['customer-brief'] ?></p>
            </div>
            <div class="owl-carousel owl-theme owl-customer">
                <?php
                $i = 0;
                foreach ($commentList as $row) { ?>
                    <div class="item-wrap ">
                        <div class="item mx-auto px-3 py-4">
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="img-box-wrap mr-3">
                                    <div class="img-box d-flex mx-auto "><img width="90" height="90" class="img img-cover" src="<?= $row->path; ?>" alt="<?= $row->name; ?>" /></div>
                                </div>
                                <div class="info ml-auto1">
                                    <div class="feed_title mb-2 d-flex justify-content-start align-items-center">
                                        <strong><?= strip_tags($row->name); ?></strong>
                                    </div>
                                    <div class="feed_job mb-0"><?= strip_tags($row->job); ?></div>
                                </div>
                            </div>
                            <div class="feed_content mt-3">
                                <div class="quote-box mb-2"></div>
                                <div class="content"><?= strip_tags($row->content); ?></div>
                            </div>
                        </div>
                    </div>
                <?php $i++; } ?>
            </div>
        </div>
    </section>
<?php } ?>