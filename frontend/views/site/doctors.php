<?php
use backend\models\Supporter;
use backend\models\CatDoctor;
use backend\models\Seo;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$seo = Seo::getSeo(Seo::DOCTOR_PAGE);
if (!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = 'Đội ngũ bác sĩ - Mammocare';
    Yii::$app->params['og_description'] = 'Đội ngũ bác sĩ chuyên khoa giàu kinh nghiệm tại Mammocare';
}
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item active">Đội ngũ bác sĩ</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Hero Section -->
<section class="doctor-hero py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <h1 class="display-4 mb-3">Đội ngũ bác sĩ chuyên khoa</h1>
                <p class="lead mb-4">Bác sĩ giàu kinh nghiệm, được đào tạo chuyên sâu về chẩn đoán hình ảnh vú</p>
                <a href="/book-doctor" class="btn btn-light btn-lg">Đặt lịch khám ngay</a>
            </div>
            <div class="col-12 col-md-4 text-center">
                <i class="fas fa-user-md fa-5x opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<!-- Doctor List -->
<?php
$doctorList = Supporter::getSupportHome();
if(!empty($doctorList)){
    ?>
    <section class="doctors-section py-5">
        <div class="container">
            <div class="row">
                <?php foreach($doctorList as $key => $row): ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?=($key+1)*100?>">
                        <div class="doctor-card h-100">
                            <div class="doctor-image">
                                <img class="img-fluid" src="<?= $row->path?$row->path:'upload/no-image.jpg'?>" alt="<?= $row->name ?>" />
                                <div class="doctor-overlay">
                                    <a href="<?=$row->getUrl()?>" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                            <div class="doctor-content">
                                <div class="doctor-specialty mb-2">
                                    <span class="badge badge-primary"><?= $row->father?$row->father->name:''?></span>
                                </div>
                                <h4 class="doctor-name mb-2">
                                    <a href="<?=$row->getUrl()?>"><?=$row->name?></a>
                                </h4>
                                <p class="doctor-brief mb-3"><?=$row->brief?></p>
                                <div class="doctor-info">
                                    <?php if($row->email): ?>
                                        <div class="doctor-contact mb-1">
                                            <i class="fas fa-envelope"></i>
                                            <a href="mailto:<?=$row->email?>"><?=$row->email?></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($row->mobile): ?>
                                        <div class="doctor-contact">
                                            <i class="fas fa-phone"></i>
                                            <a href="tel:<?=$row->mobile?>"><?=$row->mobile?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <style>
    .doctor-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .doctor-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .doctor-image {
        position: relative;
        height: 300px;
        overflow: hidden;
    }
    .doctor-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .doctor-card:hover .doctor-image img {
        transform: scale(1.1);
    }
    .doctor-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(0,123,255,0.8), rgba(0,123,255,0.6));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .doctor-card:hover .doctor-overlay {
        opacity: 1;
    }
    .doctor-content {
        padding: 25px;
    }
    .doctor-specialty .badge {
        font-size: 0.8rem;
        padding: 5px 12px;
    }
    .doctor-name {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .doctor-name a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .doctor-name a:hover {
        color: #007bff;
    }
    .doctor-brief {
        color: #666;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    .doctor-contact {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    .doctor-contact i {
        color: #007bff;
        margin-right: 10px;
        width: 16px;
    }
    .doctor-contact a {
        color: #666;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }
    .doctor-contact a:hover {
        color: #007bff;
    }
    .doctor-hero {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }
    .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #6c757d;
    }
    </style>
<?php } ?>

<!-- CTA Section -->
<section class="cta-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <h3 class="mb-2">Sẵn sàng đặt lịch khám?</h3>
                <p class="mb-0">Liên hệ ngay để được tư vấn và đặt lịch khám phù hợp</p>
            </div>
            <div class="col-12 col-md-4 text-center text-md-right">
                <a href="/book-doctor" class="btn btn-primary btn-lg mr-2">Đặt lịch ngay</a>
                <a href="tel:<?=$cont->hotline?>" class="btn btn-outline-primary btn-lg">Gọi hotline</a>
            </div>
        </div>
    </div>
</section>
