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
use backend\models\Menu;
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
                         <a href="/mammocare-a1.html" class="btn btn-outline-primary">Tìm hiểu thêm</a>
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
// Lấy từ menu dịch vụ
$serviceList = Menu::getMenu(Menu::MAIN_MENU);
$serviceItems = [];
foreach($serviceList as $menu) {
    if($menu->name == 'Dịch vụ' || $menu->name == 'DỊCH VỤ') {
        $serviceItems = $menu->getSubMenu();
        break;
    }
}
if(!empty($serviceItems)){
    $featuredServices = array_slice($serviceItems, 0, 3); // Lấy 3 dịch vụ đầu tiên
    ?>
     <section class="featured-services py-4 py-lg-5 bg-light">
         <div class="container">
             <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                 <h2 class="mb-2">3 Dịch vụ nổi bật</h2>
                 <p class="mb-0">Các dịch vụ y tế hàng đầu của chúng tôi</p>
             </div>
             <div class="row align-items-stretch">
                 <?php 
                 $colors = ['#007bff', '#e91e63', '#007bff']; // Màu xanh, hồng, xanh
                 foreach ($featuredServices as $key => $row): 
                     $color = $colors[$key % 3];
                 ?>
                     <div class="col-12 col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?=($key+1)*100?>">
                         <div class="service-card h-100 d-flex flex-column">
                             <div class="service-content" style="background-color: <?= $color ?>; color: white; padding: 30px; border-radius: 15px; position: relative;">
                                 <div class="service-icon mb-4 text-center">
                                     <i class="fas fa-stethoscope fa-3x" style="opacity: 0.9;"></i>
                                 </div>
                                 <h4 class="service-title mb-4 text-center" style="color: white; font-weight: 700; font-size: 1.2rem; line-height: 1.3;"><?=strip_tags($row->name)?></h4>
                                 <p class="service-description mb-4" style="color: white; line-height: 1.6; text-align: center; font-size: 0.95rem; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;"><?=strip_tags(substr($row->description, 0, 150))?>...</p>
                                 <div class="service-button text-center">
                                     <a href="<?= $row->link ?>" class="btn btn-sm service-btn" style="background-color: white; color: <?= $color ?>; border: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">Xem chi tiết dịch vụ</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 <?php endforeach; ?>
             </div>
         </div>
     </section>
    
    <style>
    .service-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
    }
    .service-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .service-card:hover .service-btn {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2) !important;
    }
    .service-content {
        border-radius: 15px;
        position: relative;
        min-height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .service-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }
    .service-title {
        font-size: 1.2rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    .service-description {
        font-size: 0.95rem;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        flex-grow: 1;
    }
    .service-btn {
        position: relative;
        overflow: hidden;
    }
    .service-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .service-btn:hover::before {
        left: 100%;
    }
    .service-icon i {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    </style>
    
    <!-- CSS cho các phần đã sửa -->
    <style>
    /* CSS cho News Cards */
    .news-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .news-image {
        border-radius: 8px;
        overflow: hidden;
    }
    .news-title a {
        color: #333;
        font-weight: 600;
        text-decoration: none;
    }
    .news-title a:hover {
        color: #007bff;
    }
    .news-brief {
        color: #666;
        line-height: 1.6;
    }
    
    /* CSS cho Doctor Section - Tăng chiều rộng */
    .doctor-home .container-fluid {
        max-width: 95%;
    }
    .doctor-home .owl-carousel {
        width: 100%;
    }
    .doctor-home .item-wrap {
        margin: 0 10px;
    }
    .doctor-home .wrap-box {
        display: flex;
        justify-content: center;
        align-items: stretch;
        gap: 20px;
    }
    .doctor-home .item {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        min-height: 400px;
    }
    .doctor-home .item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .doctor-home .img-box {
        height: 200px;
        margin-bottom: 15px;
    }
    .doctor-home .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }
    .doctor-home .info-box {
        text-align: left;
    }
    .doctor-home .specialist {
        color: #007bff;
        font-weight: 600;
        font-size: 14px;
    }
    .doctor-home .name {
        color: #333;
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 10px;
    }
    .doctor-home .brief {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .doctor-home .info {
        color: #555;
        font-size: 13px;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    .doctor-home .email,
    .doctor-home .phone {
        display: block;
        color: #007bff;
        font-size: 13px;
        margin-bottom: 5px;
        text-decoration: none;
    }
    .doctor-home .email:hover,
    .doctor-home .phone:hover {
        color: #0056b3;
    }
    
    /* CSS cho Testimonials - Giống thiết kế cũ */
    .testimonials .item {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin: 0 10px;
        max-width: 350px;
    }
    .testimonials .feed_title {
        color: #333;
        font-weight: 700;
        font-size: 16px;
    }
    .testimonials .feed_job {
        font-size: 14px;
        font-weight: 500;
    }
    .testimonials .content {
        font-size: 14px;
        text-align: left;
    }
    .testimonials .img-box img {
        border: 2px dotted #ff6b9d !important;
    }
    
    /* CSS cho tiêu đề chính - Giống thiết kế ảnh */
    .header-box h2 {
        font-size: 2.5rem !important;
        font-weight: 700 !important;
        color: #289cd7 !important; /* Màu xanh #289cd7 */
        margin-bottom: 0.5rem !important;
        line-height: 1.2 !important;
    }
    .header-box p {
        font-size: 1.1rem !important;
        color: #374151 !important; /* Màu xám đậm */
        font-weight: 400 !important;
        margin-bottom: 0 !important;
    }
    
    /* CSS cho tiêu đề tin tức */
    .news-title a {
        font-size: 1.2rem !important;
        font-weight: 700 !important;
        color: #289cd7 !important; /* Màu xanh #289cd7 */
        line-height: 1.4 !important;
    }
    
    /* CSS cho tên khách hàng */
    .testimonials .feed_title {
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        color: #000 !important; /* Màu đen */
    }
    
    /* CSS cho avatar nhỏ hơn */
    .testimonials .img-box img {
        width: 40px !important;
        height: 40px !important;
        border: 2px dotted #ff6b9d !important;
    }
    
    /* CSS giới hạn số dòng nội dung */
    .testimonials .content {
        display: -webkit-box;
        -webkit-line-clamp: 4; /* Giới hạn tối đa 4 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.5;
        max-height: 6rem; /* 4 dòng x 1.5 line-height */
    }
    
    /* Đảm bảo các card có chiều cao bằng nhau */
    .testimonials .item {
        min-height: 280px;
        display: flex;
        flex-direction: column;
    }
    
    .testimonials .feed_content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    </style>
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
        <div class="container-fluid px-4">
             <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                 <h2 class="mb-2">Đội ngũ bác sĩ</h2>
                 <p class="mb-0">Bác sĩ chuyên khoa giàu kinh nghiệm</p>
                 <div class="mt-3">
                     <a href="/bac-si" class="btn btn-outline-primary">Xem tất cả bác sĩ</a>
                 </div>
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
                <h2 class="mb-2">Khách hàng đánh giá về MammoCare</h2>
                <p class="mb-0">Hơn 5000+ khách hàng đang sử dụng dịch vụ của chúng tôi</p>
            </div>
            <div class="owl-carousel owl-theme owl-customer">
                <?php
                $i = 0;
                foreach ($commentList as $row) { ?>
                    <div class="item-wrap">
                        <div class="item mx-auto px-3 py-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="img-box-wrap mr-3">
                                    <div class="img-box d-flex">
                                        <img width="40" height="40" class="img img-cover rounded-circle" src="<?= $row->path; ?>" alt="<?= $row->name; ?>" style="border: 2px dotted #ff6b9d;" />
                                    </div>
                                </div>
                                <div class="info">
                                    <div class="feed_title mb-1">
                                        <strong style="color: #000;"><?= strip_tags($row->name); ?></strong>
                                    </div>
                                    <div class="feed_job mb-0" style="color: #ff6b9d;"><?= strip_tags($row->job); ?></div>
                                </div>
                            </div>
                            <div class="feed_content">
                                <div class="content" style="color: #4a90e2; line-height: 1.6;"><?= strip_tags($row->content); ?></div>
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
                <h2 class="mb-2">Tin tức sự kiện mới nhất</h2>
                <p class="mb-0">của trung tâm chẩn đoán hình ảnh vú Mammocare</p>
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
