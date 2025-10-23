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

<!-- 2. TIN TỨC NỔI BẬT (thay cho Giới thiệu) -->
<?php
$news = News::getHomeNews();
if (!empty($news)) {
    $highlightNews = array_slice($news, 0, 3);
    ?>
    <section class="latest-news py-4 py-lg-5 news">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-2">Tin tức nổi bật</h2>
                <p class="mb-0">Cập nhật hoạt động và sự kiện mới nhất của Mammocare</p>
            </div>
            <div class="row">
                <?php $i = 1; foreach ($highlightNews as $row): 
                    $url = $row->getUrl();
                    $cat_home = CatNews::findOne($row->cat_id);
                    $urlCat = $cat_home ? $cat_home->getUrl() : '#';
                ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                        <div class="item h-100">
                            <div class="img-box mb-0">
                                <div class="image_inner d-flex">
                                    <a href="<?= $url ?>">
                                        <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->title ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="item-body p-3">
                                <div class="d-flex cat-date mb-3 pb-3 border-bottom">
                                    <span class="date mb-0 mr-4"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($row->created_at)) ?></span>
                                    <?php if ($cat_home): ?>
                                        <a href="<?= $urlCat ?>" class=""><i class="fas fa-bars"></i> <?= $cat_home->name ?></a>
                                    <?php endif; ?>
                                </div>
                                <h5 class="item-title mb-3">
                                    <a href="<?= $url ?>"><?= $row->title ?></a>
                                </h5>
                                <p class="content mb-2 d-none"><?= strip_tags(substr($row->brief, 0, 160)) ?>...</p>
                                <a class="more d-inline-block px-3" href="<?= $url ?>"><?= Yii::t('app','more1') ?> <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
            <div class="text-center mt-2 mt-lg-3">
                <a href="/tin-tuc-l3" class="btn btn-primary">Xem tất cả tin tức</a>
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
    
    // Log data của featuredServices
    error_log("=== FEATURED SERVICES DATA ===");
    error_log("Number of featured services: " . count($featuredServices));
    foreach($featuredServices as $index => $service) {
        error_log("Service " . ($index + 1) . ":");
        error_log("  - ID: " . (isset($service->id) ? $service->id : 'N/A'));
        error_log("  - Name: " . (isset($service->name) ? $service->name : 'N/A'));
        error_log("  - Description: " . (isset($service->description) ? $service->description : 'N/A'));
        error_log("  - Link: " . (isset($service->link) ? $service->link : 'N/A'));
        error_log("  - Full object: " . print_r($service, true));
    }
    error_log("=== END FEATURED SERVICES DATA ===");
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
    /* CSS cho News Cards - đồng bộ hoàn toàn với trang danh sách tin */
    .latest-news .item {
        height: 100%;
        background: #fff;
        box-shadow: 0px 10px 30px 0px rgba(50, 50, 50, 0.16);
        border-radius: 0;
        overflow: hidden;
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .latest-news .item:hover {
        box-shadow: 0px 10px 30px 0px rgb(126, 126, 126);
        margin-top: -8px;
    }
    .latest-news .item-body {
        position: relative;
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .latest-news .item-title {
        font-size: 18px;
        line-height: 28px;
        font-weight: 600;
        margin-bottom: 15px;
    }
    .latest-news .item-title a {
        color: #333;
        text-decoration: none;
    }
    .latest-news .item-title a:hover {
        color: #007bff;
    }
    .latest-news .cat-date {
        font-size: 13px;
        color: #504f4f;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .latest-news .cat-date a {
        color: #504f4f;
        text-decoration: none;
    }
    .latest-news .cat-date i {
        color: #ff6b9d;
        margin-right: 5px;
    }
    .latest-news .date {
        font-size: 13px;
        color: #504f4f;
    }
    .latest-news .date i {
        color: #a6a6a6;
        margin-right: 5px;
    }
    .latest-news .more {
        background: #ff6b9d;
        color: #fff;
        border-radius: 5px;
        line-height: 35px;
        border: 2px solid #ff6b9d;
        text-decoration: none;
        display: inline-block;
        padding: 0 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: auto; /* Đẩy button xuống dưới cùng */
        align-self: flex-start; /* Căn trái button */
    }
    .latest-news .more:hover {
        background: #fff;
        color: #ff6b9d;
    }
    .latest-news .more i {
        margin-left: 5px;
    }
    /* Button "Xem tất cả tin tức" - đồng bộ với style chung */
    .latest-news .btn-primary {
        background: #ff6b9d;
        border-color: #ff6b9d;
        color: #fff;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 600;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }
    .latest-news .btn-primary:hover {
        background: #e55a8a;
        border-color: #e55a8a;
        color: #fff;
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
    
    /* CSS cho Customer Reviews - Layout 2 cột */
    .customer-reviews {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    /* Video Container */
    .video-container {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        background: white;
    }
    
    .video-wrapper {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
    }
    
    .youtube-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 20px;
    }
    
    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, transparent 30%, transparent 70%, rgba(0,0,0,0.4) 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .video-container:hover .video-overlay {
        opacity: 1;
    }
    
    .video-info {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .hospital-logo {
        display: flex;
        align-items: center;
        color: white;
    }
    
    .logo-icon {
        width: 40px;
        height: 40px;
        background: #289cd7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    
    .logo-text strong {
        display: block;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
    }
    
    .logo-text span {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .video-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .action-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .action-btn:hover {
        background: rgba(255,255,255,0.3);
    }
    
    .video-footer {
        display: flex;
        justify-content: flex-start;
    }
    
    .watch-on-btn {
        background: #ff0000;
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .watch-on-btn:hover {
        background: #cc0000;
    }
    
    /* Reviews Container */
    .reviews-container {
        padding: 2rem;
    }
    
    .reviews-header h3 {
        color: #289cd7;
        font-weight: 700;
        font-size: 1.8rem;
    }
    
    .review-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: none;
        margin: 0 0.5rem;
        transition: transform 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .review-card:hover {
        transform: translateY(-2px);
    }
    
    .review-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .customer-avatar {
        margin-right: 1rem;
    }
    
    .avatar-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #289cd7;
    }
    
    .customer-info {
        flex: 1;
    }
    
    .customer-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.2rem;
    }
    
    .customer-job {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0;
    }
    
    .rating {
        color: #ffc107;
        font-size: 1rem;
    }
    
    .review-content p {
        color: #495057;
        line-height: 1.6;
        margin-bottom: 0;
        font-style: italic;
    }
    
    .reviews-actions .btn {
        background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
        border: none;
        border-radius: 25px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .reviews-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40,156,215,0.3);
    }
    
    /* Responsive Design cho Customer Reviews */
    @media (max-width: 992px) {
        .customer-reviews .row {
            flex-direction: column;
        }
        
        .video-container {
            margin-bottom: 2rem;
        }
        
        .reviews-container {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .customer-reviews {
            padding: 2rem 0;
        }
        
        .video-container {
            border-radius: 15px;
        }
        
        .video-overlay {
            padding: 1rem;
        }
        
        .hospital-logo {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .logo-icon {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
        
        .video-actions {
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .action-btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .watch-on-btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
        
        .reviews-container {
            padding: 1rem;
        }
        
        .reviews-header h3 {
            font-size: 1.5rem;
        }
        
        .review-card {
            padding: 1.2rem;
            margin: 0 0.3rem;
            box-shadow: none;
        }
        
        .customer-name {
            font-size: 1rem;
        }
        
        .customer-job {
            font-size: 0.85rem;
        }
        
        .avatar-img {
            width: 45px;
            height: 45px;
        }
    }
    
    @media (max-width: 576px) {
        .video-overlay {
            padding: 0.8rem;
        }
        
        .logo-text strong {
            font-size: 1rem;
        }
        
        .logo-text span {
            font-size: 0.8rem;
        }
        
        .action-btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }
        
        .watch-on-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
        
        .reviews-header h3 {
            font-size: 1.3rem;
        }
        
        .review-card {
            padding: 1rem;
            box-shadow: none;
        }
        
        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .customer-avatar {
            margin-right: 0;
        }
        
        .avatar-img {
            width: 40px;
            height: 40px;
        }
        
        .customer-name {
            font-size: 0.95rem;
        }
        
        .customer-job {
            font-size: 0.8rem;
        }
        
        .rating {
            font-size: 0.9rem;
        }
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
            <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
                <?php
                foreach($doctorList as $row):
                ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="doctor-card h-100 text-center">
                        <div class="doctor-image mb-3">
                            <img class="img-fluid rounded-circle" 
                                 src="<?= $row->path ? $row->path : 'upload/no-image.jpg' ?>" 
                                 alt="<?= $row->name ?>" 
                                 title="<?= $row->name ?>"
                                 style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;"
                                 onclick="location.href='<?=$row->getUrl()?>';" />
                        </div>
                        <div class="doctor-info">
                            <p class="specialist mb-1 text-muted small"><?= $row->father ? $row->father->name : '' ?></p>
                            <h5 class="doctor-name mb-2">
                                <a href="<?=$row->getUrl()?>" class="text-decoration-none text-dark"><?=$row->name?></a>
                            </h5>
                            <p class="doctor-brief mb-2 text-primary small"><?=$row->brief?></p>
                            <p class="doctor-content mb-3 small text-muted"><?=$row->content?></p>
                            <div class="doctor-contact">
                                <a class="d-block mb-1 text-decoration-none small" href="mailto:<?=$row->email?>">
                                    <i class="far fa-envelope me-1"></i> <?=$row->email?>
                                </a>
                                <a class="d-block text-decoration-none small" href="tel:<?=$row->mobile?>">
                                    <i class="fas fa-phone-alt me-1"></i> <?=$row->mobile?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            </div>
        </div>
    </section>
<?php } ?>

<!-- 6. CUSTOMER REVIEWS - 2 COLUMN LAYOUT -->
<?php
$commentList = Comment::getComment();

// Nếu không có data từ database, tạo data mẫu
if (empty($commentList)) {
    $commentList = [];
    
    // Tạo data mẫu cho reviews
    $sampleComments = [
        [
            'id' => 1,
            'name' => 'Nguyễn Thị Lan',
            'job' => 'Nhân viên văn phòng',
            'content' => 'Dịch vụ rất chuyên nghiệp, bác sĩ tận tình. Kết quả chính xác và nhanh chóng. Tôi rất hài lòng với chất lượng dịch vụ tại MammoCare.',
            'path' => 'bundle/images/avatar1.jpg'
        ],
        [
            'id' => 2,
            'name' => 'Trần Văn Minh',
            'job' => 'Kinh doanh',
            'content' => 'Thiết bị hiện đại, đội ngũ bác sĩ giàu kinh nghiệm. Quy trình khám bệnh rất thuận tiện và nhanh gọn. Cảm ơn MammoCare!',
            'path' => 'bundle/images/avatar2.jpg'
        ],
        [
            'id' => 3,
            'name' => 'Lê Thị Hoa',
            'job' => 'Giáo viên',
            'content' => 'Lần đầu khám tại đây, tôi rất lo lắng. Nhưng bác sĩ và nhân viên đã tư vấn rất tận tình, giúp tôi yên tâm. Kết quả rất chính xác.',
            'path' => 'bundle/images/avatar3.jpg'
        ],
        [
            'id' => 4,
            'name' => 'Phạm Văn Đức',
            'job' => 'Kỹ sư',
            'content' => 'Cơ sở vật chất hiện đại, bác sĩ chuyên môn cao. Quy trình khám bệnh được tối ưu hóa, tiết kiệm thời gian. Rất hài lòng!',
            'path' => 'bundle/images/avatar4.jpg'
        ]
    ];
    
    foreach($sampleComments as $data) {
        $comment = new \stdClass();
        $comment->id = $data['id'];
        $comment->name = $data['name'];
        $comment->job = $data['job'];
        $comment->content = $data['content'];
        $comment->path = $data['path'];
        $commentList[] = $comment;
    }
}

if (!empty($commentList)) {
?>
    <section class="customer-reviews py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="header-box mb-4 mb-lg-5 text-center" data-aos="fade-up" data-aos-delay="100">
                <h2 class="mb-2">Phòng Khám & Trang Thiết Bị Hàng Đầu Việt Nam</h2>
                <p class="mb-0">Với sứ mệnh "Chữa bệnh – cứu người", MammoCare trong suốt 10 năm qua đã dốc sức, tận tâm vì sức khỏe cộng đồng</p>
            </div>
            
            <div class="row align-items-center">
                <!-- Cột trái: Video YouTube -->
                <div class="col-12 col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
                    <div class="video-container">
                        <div class="video-wrapper">
                            <iframe 
                                src="https://www.youtube.com/embed/bz7eihJoJlI?start=11&autoplay=0&rel=0&modestbranding=1" 
                                title="Khám với chuyên gia - Tận tâm nh..."
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="youtube-video">
                            </iframe>
                        </div>
                        <div class="video-overlay">
                            <div class="video-info">
                                <div class="hospital-logo">
                                    <div class="logo-icon">
                                        <i class="fas fa-hospital"></i>
                                    </div>
                                    <div class="logo-text">
                                        <strong>MammoCare</strong>
                                        <span>Trung tâm chẩn đoán hình ảnh vú</span>
                                    </div>
                                </div>
                                <div class="video-actions">
                                    <button class="action-btn" title="Xem sau">
                                        <i class="far fa-clock"></i>
                                        <span>Xem sau</span>
                                    </button>
                                    <button class="action-btn" title="Chia sẻ">
                                        <i class="fas fa-share"></i>
                                        <span>Chia sẻ</span>
                                    </button>
                                </div>
                            </div>
                            <div class="video-footer">
                                <button class="watch-on-btn">
                                    <i class="fab fa-youtube"></i>
                                    <span>Xem trên</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cột phải: Đánh giá khách hàng -->
                <div class="col-12 col-lg-6" data-aos="fade-left" data-aos-delay="300">
                    <div class="reviews-container">
                        <div class="reviews-header mb-4">
                            <h3 class="mb-3">Khách hàng đánh giá</h3>
                            <p class="text-muted mb-0">Hơn 5000+ khách hàng đang sử dụng dịch vụ của chúng tôi</p>
                        </div>
                        
                        <div class="reviews-carousel">
                            <div class="owl-carousel owl-theme owl-customer-reviews">
                                <?php
                                $i = 0;
                                foreach ($commentList as $row) { ?>
                                    <div class="review-item">
                                        <div class="review-card">
                                            <div class="review-header">
                                                <div class="customer-avatar">
                                                    <img src="<?= $row->path; ?>" alt="<?= $row->name; ?>" class="avatar-img">
                                                </div>
                                                <div class="customer-info">
                                                    <h5 class="customer-name"><?= strip_tags($row->name); ?></h5>
                                                    <p class="customer-job"><?= strip_tags($row->job); ?></p>
                                                </div>
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="review-content">
                                                <p><?= strip_tags($row->content); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php $i++; } ?>
                            </div>
                        </div>
                        
                        <div class="reviews-actions mt-4">
                            <button class="btn btn-primary">
                                <i class="fas fa-arrow-right me-2"></i>
                                Tìm Hiểu Thêm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php // Tin tức dưới footer đã được bỏ theo yêu cầu ?>

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

<script>
// Đợi jQuery và Owl Carousel load xong
function initCustomerReviews() {
    if (typeof $ !== 'undefined' && typeof $.fn.owlCarousel !== 'undefined') {
        // Khởi tạo Owl Carousel cho Customer Reviews
        if ($('.owl-customer-reviews').length) {
            $('.owl-customer-reviews').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    992: {
                        items: 1
                    }
                }
            });
        }
    } else {
        // Nếu jQuery chưa load, thử lại sau 100ms
        setTimeout(initCustomerReviews, 100);
    }
}

// Chạy khi DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCustomerReviews);
} else {
    initCustomerReviews();
}
</script>
