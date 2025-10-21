<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Đặt lịch khám - Mammocare';
Yii::$app->params['og_description'] = 'Đặt lịch khám trực tuyến tại Mammocare - Dịch vụ chuyên khoa tuyến vú hàng đầu';
?>

<style>
.booking-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.booking-hero {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.booking-hero::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.booking-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: white;
}

.booking-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.feature-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2rem;
}

.feature-badge {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 25px;
    padding: 0.8rem 1.5rem;
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.feature-badge:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
}

.booking-icon {
    position: relative;
    z-index: 2;
}

.booking-icon i {
    font-size: 6rem;
    color: rgba(255,255,255,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.booking-options {
    padding: 4rem 0;
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    font-weight: 400;
}

.booking-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.booking-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(40,156,215,0.15);
}

.booking-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.card-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
}

.card-icon.online {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.card-icon.hotline {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.card-icon.whatsapp {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    text-align: center;
}

.card-description {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    text-align: center;
}

.feature-list {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

.feature-list li {
    display: flex;
    align-items: center;
    margin-bottom: 0.8rem;
    color: #495057;
    font-size: 0.95rem;
}

.feature-list li i {
    color: #28a745;
    margin-right: 0.8rem;
    font-size: 1rem;
}

.booking-btn {
    width: 100%;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
}

.booking-btn.online {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    color: white;
}

.booking-btn.hotline {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.booking-btn.whatsapp {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: white;
}

.booking-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: white;
    text-decoration: none;
}

.info-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    margin-top: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.info-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
}

.info-card:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
}

.info-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    color: white;
}

.info-icon.prepare {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.info-icon.process {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.info-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.info-subtitle {
    color: #289cd7;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 1rem;
}

.info-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .booking-hero h1 {
        font-size: 2.5rem;
    }
    
    .booking-hero p {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .booking-card {
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .feature-badges {
        justify-content: center;
    }
    
    .booking-icon i {
        font-size: 4rem;
    }
}
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::home() ?>">Trang chủ</a></li>
                <li class="breadcrumb-item active">Đặt lịch khám</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Booking Page -->
<div class="booking-page">
    <!-- Hero Section -->
    <section class="booking-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Đặt lịch khám</h1>
                    <p>Đặt lịch khám trực tuyến nhanh chóng và tiện lợi tại Mammocare</p>
                    <div class="feature-badges">
                        <span class="feature-badge">
                            <i class="fas fa-clock me-2"></i>Linh hoạt thời gian
                        </span>
                        <span class="feature-badge">
                            <i class="fas fa-user-md me-2"></i>Bác sĩ chuyên khoa
                        </span>
                        <span class="feature-badge">
                            <i class="fas fa-shield-alt me-2"></i>An toàn & Bảo mật
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="booking-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Booking Options -->
    <section class="booking-options">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Chọn cách đặt lịch phù hợp</h2>
                <p class="section-subtitle">Chúng tôi cung cấp nhiều cách thức đặt lịch để phù hợp với nhu cầu của bạn</p>
            </div>
            
            <div class="row g-4">
                <!-- Online Booking -->
                <div class="col-lg-4 col-md-6">
                    <div class="booking-card">
                        <div class="card-icon online">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3 class="card-title">Đặt lịch Online</h3>
                        <p class="card-description">Đặt lịch trực tuyến 24/7 với form đơn giản, nhanh chóng</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i>Chọn dịch vụ & chi nhánh</li>
                            <li><i class="fas fa-check"></i>Chọn bác sĩ & thời gian</li>
                            <li><i class="fas fa-check"></i>Nhập thông tin cá nhân</li>
                            <li><i class="fas fa-check"></i>Nhận xác nhận ngay lập tức</li>
                        </ul>
                        <a href="<?= Url::to(['site/booking-online']) ?>" class="booking-btn online">
                            <i class="fas fa-calendar-plus"></i>Đặt lịch Online
                        </a>
                    </div>
                </div>

                <!-- Hotline Booking -->
                <div class="col-lg-4 col-md-6">
                    <div class="booking-card">
                        <div class="card-icon hotline">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3 class="card-title">Đặt lịch qua Hotline</h3>
                        <p class="card-description">Gọi trực tiếp để được tư vấn và đặt lịch phù hợp</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i>Tư vấn chuyên sâu</li>
                            <li><i class="fas fa-check"></i>Hỗ trợ 24/7</li>
                            <li><i class="fas fa-check"></i>Giải đáp thắc mắc</li>
                            <li><i class="fas fa-check"></i>Đặt lịch ngay lập tức</li>
                        </ul>
                        <a href="tel:1900099990" class="booking-btn hotline">
                            <i class="fas fa-phone"></i>Gọi 1900.099990
                        </a>
                    </div>
                </div>

                <!-- WhatsApp Booking -->
                <div class="col-lg-4 col-md-6">
                    <div class="booking-card">
                        <div class="card-icon whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h3 class="card-title">Đặt lịch qua WhatsApp</h3>
                        <p class="card-description">Chat trực tiếp với chúng tôi qua WhatsApp</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i>Chat trực tiếp</li>
                            <li><i class="fas fa-check"></i>Gửi hình ảnh</li>
                            <li><i class="fas fa-check"></i>Nhận tư vấn nhanh</li>
                            <li><i class="fas fa-check"></i>Tiện lợi mọi lúc</li>
                        </ul>
                        <a href="https://wa.me/84900099990" target="_blank" class="booking-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Useful Information -->
    <section class="booking-options">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Thông tin hữu ích</h2>
                <p class="section-subtitle">Chuẩn bị tốt nhất cho lần khám của bạn</p>
            </div>
            
            <div class="info-section">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="info-card" onclick="window.location.href='<?= Url::to(['site/booking-prepare']) ?>'">
                            <div class="info-icon prepare">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h4 class="info-title">Chuẩn bị khám</h4>
                            <p class="info-subtitle">Hướng dẫn chi tiết cho từng loại dịch vụ</p>
                            <p class="info-description">
                                Tìm hiểu cách chuẩn bị tốt nhất cho lần khám của bạn, bao gồm các yêu cầu về ăn uống, thuốc men và các lưu ý quan trọng.
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="info-card" onclick="window.location.href='<?= Url::to(['site/booking-process']) ?>'">
                            <div class="info-icon process">
                                <i class="fas fa-route"></i>
                            </div>
                            <h4 class="info-title">Quy trình khám</h4>
                            <p class="info-subtitle">Timeline từ đặt lịch đến nhận kết quả</p>
                            <p class="info-description">
                                Hiểu rõ quy trình khám từ A-Z, từ lúc đặt lịch, đến khám, nhận kết quả và tư vấn sau khám.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>