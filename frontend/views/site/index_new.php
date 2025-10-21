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

<!-- 1. HERO SECTION với CTA "Đặt lịch khám ngay" -->
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
                                <!-- CTA Button -->
                                <div class="cta-section">
                                    <a href="/book-doctor" class="btn btn-primary btn-lg">Đặt lịch khám ngay</a>
                                </div>
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
                                            <div class="cta-section">
                                                <a href="/book-doctor" class="btn btn-primary btn-lg">Đặt lịch khám ngay</a>
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

<!-- 2. GIỚI THIỆU NGẮN VỀ MAMMOCARE -->
<?php
$aboutList = Partner::getPartner(Partner::ABOUTUS,1);
$aboutSign = Partner::getPartner(Partner::ABOUTLINK,1);
if(!empty($aboutList)){
    $ab=$aboutList[0];
    ?>
    <section class="about-home-short py-4 py-lg-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="about-content">
                        <h2 class="mb-3"><?= $ab->name; ?></h2>
                        <div class="brief mb-4"><?= strip_tags(substr($ab->content, 0, 300)) ?>...</div>
                        <a href="/gioi-thieu-a1.html" class="btn btn-outline-primary">Tìm hiểu thêm</a>
                    </div>
                </div>
                <div class="col-12 col-md-6" data-aos="fade-left" data-aos-delay="100">
                    <div class="about-image">
                        <img class="img-fluid" src="<?= $ab->path; ?>" alt="<?= $ab->name; ?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!-- 3. 3 DỊCH VỤ NỔI BẬT -->
<?php
$serviceList = Partner::getPartner(Partner::SERVICE);
if(!empty($serviceList)){
    $featuredServices = array_slice($serviceList, 0, 3); // Lấy 3 dịch vụ đầu tiên
    ?>
    <section class="featured-services py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-2">3 Dịch vụ nổi bật</h2>
                <p class="mb-0">Các dịch vụ chẩn đoán hình ảnh vú chuyên nghiệp</p>
            </div>
            <div class="row">
                <?php foreach ($featuredServices as $key => $row): ?>
                    <div class="col-12 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?=($key+1)*100?>">
                        <div class="service-card h-100 text-center">
                            <div class="service-image mb-3">
                                <img class="img-fluid" src="<?= $row->path ?>" alt="<?= $row->name; ?>">
                            </div>
                            <h4 class="service-title mb-3"><?=strip_tags($row->name)?></h4>
                            <p class="service-description mb-3"><?=strip_tags(substr($row->content, 0, 150))?>...</p>
                            <a href="<?= $row->url ?>" class="btn btn-primary">Tìm hiểu thêm</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php } ?>

<!-- 4. 4 LÝ DO CHỌN MAMMOCARE -->
<section class="reasons-section py-4 py-lg-5">
    <div class="container">
        <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
            <h2 class="mb-2">4 Lý do chọn Mammocare</h2>
            <p class="mb-0">Tại sao hàng nghìn khách hàng tin tưởng chúng tôi</p>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="reason-card text-center h-100">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-user-md fa-3x text-primary"></i>
                    </div>
                    <h4 class="reason-title mb-3">Đội ngũ bác sĩ chuyên khoa</h4>
                    <p class="reason-description">Bác sĩ giàu kinh nghiệm, được đào tạo chuyên sâu về chẩn đoán hình ảnh vú</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="reason-card text-center h-100">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-cogs fa-3x text-primary"></i>
                    </div>
                    <h4 class="reason-title mb-3">Thiết bị hiện đại</h4>
                    <p class="reason-description">Máy móc tiên tiến, công nghệ 3D Tomosynthesis cho kết quả chính xác cao</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="reason-card text-center h-100">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-clock fa-3x text-primary"></i>
                    </div>
                    <h4 class="reason-title mb-3">Kết quả nhanh chóng</h4>
                    <p class="reason-description">Trả kết quả trong ngày, hỗ trợ tư vấn trực tiếp từ bác sĩ</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="reason-card text-center h-100">
                    <div class="reason-icon mb-3">
                        <i class="fas fa-heart fa-3x text-primary"></i>
                    </div>
                    <h4 class="reason-title mb-3">Chăm sóc tận tình</h4>
                    <p class="reason-description">Quy trình chuẩn quốc tế, môi trường thân thiện, bảo mật thông tin</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. ĐỘI NGŨ BÁC SĨ -->
<?php
$doctorList = Supporter::getSupportHome();
if(!empty($doctorList)){
    ?>
    <section class="doctor-home py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-2">Đội ngũ bác sĩ</h2>
                <p class="mb-0">Bác sĩ chuyên khoa giàu kinh nghiệm</p>
            </div>
            <div class="row">
                <?php
                $i=1;
                foreach($doctorList as $row):
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?=$i*100?>">
                        <div class="doctor-card text-center h-100">
                            <div class="doctor-image mb-3">
                                <img class="img-fluid rounded-circle" src="<?= $row->path?$row->path:'upload/no-image.jpg'?>" alt="<?= $row->name ?>" />
                            </div>
                            <h4 class="doctor-name mb-2"><?=$row->name?></h4>
                            <p class="doctor-specialty mb-2 text-primary"><?= $row->father?$row->father->name:''?></p>
                            <p class="doctor-brief mb-3"><?=$row->brief?></p>
                            <div class="doctor-contact">
                                <a class="btn btn-outline-primary btn-sm" href="<?=$row->getUrl()?>">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                endforeach;
                ?>
            </div>
        </div>
    </section>
<?php } ?>

<!-- 6. TESTIMONIALS -->
<?php
$commentList = Comment::getComment();
if (!empty($commentList)) {
?>
    <section class="testimonials py-4 py-lg-5">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-2">Khách hàng nói gì về chúng tôi</h2>
                <p class="mb-0">Những chia sẻ chân thực từ khách hàng</p>
            </div>
            <div class="owl-carousel owl-theme owl-customer">
                <?php
                $i = 0;
                foreach ($commentList as $row) { ?>
                    <div class="item-wrap">
                        <div class="item mx-auto px-3 py-4">
                            <div class="d-flex align-items-center justify-content-start mb-3">
                                <div class="img-box-wrap mr-3">
                                    <div class="img-box d-flex mx-auto"><img width="60" height="60" class="img img-cover rounded-circle" src="<?= $row->path; ?>" alt="<?= $row->name; ?>" /></div>
                                </div>
                                <div class="info">
                                    <div class="feed_title mb-1">
                                        <strong><?= strip_tags($row->name); ?></strong>
                                    </div>
                                    <div class="feed_job mb-0 text-muted"><?= strip_tags($row->job); ?></div>
                                </div>
                            </div>
                            <div class="feed_content">
                                <div class="content"><?= strip_tags($row->content); ?></div>
                            </div>
                        </div>
                    </div>
                <?php $i++; } ?>
            </div>
        </div>
    </section>
<?php } ?>

<!-- 7. TIN TỨC MỚI NHẤT -->
<?php
$news = News::getHomeNews();
if (!empty($news)) {
    ?>
    <section class="latest-news py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-2">Tin tức mới nhất</h2>
                <p class="mb-0">Cập nhật thông tin y khoa và hoạt động của trung tâm</p>
            </div>
            <div class="row">
                <?php
                $i=1;
                foreach ($news as $row){
                    $cat_home=CatNews::findOne($row->cat_id);
                    $url = $row->getUrl();
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                        <div class="news-card h-100">
                            <div class="news-image mb-3">
                                <img class="img-fluid" src="<?= $row->path ?>" alt="<?= $row->title ?>">
                            </div>
                            <div class="news-content">
                                <h5 class="news-title mb-2">
                                    <a href="<?= $url ?>"><?= $row->title ?></a>
                                </h5>
                                <p class="news-brief mb-3"><?=strip_tags(substr($row->brief, 0, 100))?>...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a class="btn btn-outline-primary btn-sm" href="<?= $url ?>">Đọc thêm</a>
                                    <span class="news-date text-muted"><?=date('d/m/Y',strtotime($row->created_at))?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
                ?>
            </div>
            <div class="text-center mt-4">
                <a href="/tin-tuc-l3" class="btn btn-primary">Xem tất cả tin tức</a>
            </div>
        </div>
    </section>
    <?php
}
?>

<!-- 8. CTA CUỐI TRANG -->
<section class="end-cta py-4 py-lg-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <h3 class="mb-2">Sẵn sàng đặt lịch khám?</h3>
                <p class="mb-0">Liên hệ ngay để được tư vấn và đặt lịch khám phù hợp</p>
            </div>
            <div class="col-12 col-md-4 text-center text-md-right">
                <a href="/book-doctor" class="btn btn-light btn-lg mr-2">Đặt lịch ngay</a>
                <a href="tel:<?=$cont->hotline?>" class="btn btn-outline-light btn-lg">Gọi hotline</a>
            </div>
        </div>
    </div>
</section>
