<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Liên hệ - Mammocare';
Yii::$app->params['og_description'] = 'Liên hệ với Mammocare - Hotline 1900.099990 - Email info@mammocare.vn - Dịch vụ chuyên khoa tuyến vú';
?>

<style>
.contact-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.contact-hero {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.contact-hero::before {
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

.contact-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: white;
}

.contact-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.contact-icon {
    position: relative;
    z-index: 2;
}

.contact-icon i {
    font-size: 6rem;
    color: rgba(255,255,255,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.contact-content {
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

.contact-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.contact-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.contact-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(40,156,215,0.15);
}

.contact-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.contact-icon-card {
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

.contact-icon-card.info {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.contact-icon-card.question {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.contact-icon-card.recruitment {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.contact-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.contact-description {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.contact-features {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

.contact-features li {
    display: flex;
    align-items: center;
    margin-bottom: 0.8rem;
    color: #495057;
    font-size: 0.95rem;
}

.contact-features li i {
    color: #28a745;
    margin-right: 0.8rem;
    font-size: 1rem;
}

.contact-btn {
    width: 100%;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
}

.contact-btn.primary {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    color: white;
}

.contact-btn.secondary {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.contact-btn.warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

.contact-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: white;
    text-decoration: none;
}

.quick-contact {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.quick-contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.quick-item {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    border-left: 4px solid #289cd7;
}

.quick-item:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
}

.quick-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.2rem;
    color: white;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.quick-item h5 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.quick-item p {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
}

.quick-item a {
    color: #289cd7;
    font-weight: 600;
    text-decoration: none;
}

.quick-item a:hover {
    text-decoration: underline;
}

.social-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.social-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.social-item {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.social-item:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
    text-decoration: none;
    color: inherit;
}

.social-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.social-icon.facebook {
    background: linear-gradient(135deg, #3b5998 0%, #2d4373 100%);
}

.social-icon.youtube {
    background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%);
}

.social-icon.zalo {
    background: linear-gradient(135deg, #0068ff 0%, #0052cc 100%);
}

.social-icon.whatsapp {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
}

.social-item h5 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.social-item p {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

@media (max-width: 768px) {
    .contact-hero h1 {
        font-size: 2.5rem;
    }
    
    .contact-hero p {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .contact-card, .quick-contact, .social-section {
        padding: 2rem;
    }
    
    .contact-icon i {
        font-size: 4rem;
    }
    
    .contact-options, .quick-contact-grid, .social-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::home() ?>">Trang chủ</a></li>
                <li class="breadcrumb-item active">Liên hệ</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Page -->
<div class="contact-page">
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Liên hệ</h1>
                    <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn - Liên hệ với Mammocare ngay hôm nay</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="contact-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="contact-content">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cách thức liên hệ</h2>
                <p class="section-subtitle">Chọn phương thức liên hệ phù hợp với nhu cầu của bạn</p>
            </div>
            
            <!-- Contact Options -->
            <div class="contact-options">
                <!-- Contact Info -->
                <div class="contact-card">
                    <div class="contact-icon-card info">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h3 class="contact-title">Thông tin liên hệ</h3>
                    <p class="contact-description">Xem thông tin chi tiết về các chi nhánh và cách liên hệ</p>
                    <ul class="contact-features">
                        <li><i class="fas fa-check"></i>Địa chỉ các chi nhánh</li>
                        <li><i class="fas fa-check"></i>Số điện thoại hotline</li>
                        <li><i class="fas fa-check"></i>Email liên hệ</li>
                        <li><i class="fas fa-check"></i>Giờ làm việc</li>
                    </ul>
                    <a href="<?= Url::to(['site/contact-info']) ?>" class="contact-btn primary">
                        <i class="fas fa-info-circle"></i>Xem thông tin
                    </a>
                </div>

                <!-- Send Question -->
                <div class="contact-card">
                    <div class="contact-icon-card question">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3 class="contact-title">Gửi câu hỏi</h3>
                    <p class="contact-description">Gửi câu hỏi chi tiết và nhận tư vấn từ chuyên gia</p>
                    <ul class="contact-features">
                        <li><i class="fas fa-check"></i>Form gửi câu hỏi chi tiết</li>
                        <li><i class="fas fa-check"></i>Chọn chuyên mục</li>
                        <li><i class="fas fa-check"></i>Upload file đính kèm</li>
                        <li><i class="fas fa-check"></i>Phản hồi nhanh chóng</li>
                    </ul>
                    <a href="<?= Url::to(['site/contact-question']) ?>" class="contact-btn secondary">
                        <i class="fas fa-paper-plane"></i>Gửi câu hỏi
                    </a>
                </div>

                <!-- Recruitment -->
                <div class="contact-card">
                    <div class="contact-icon-card recruitment">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="contact-title">Tuyển dụng</h3>
                    <p class="contact-description">Tìm hiểu cơ hội nghề nghiệp và ứng tuyển tại Mammocare</p>
                    <ul class="contact-features">
                        <li><i class="fas fa-check"></i>Vị trí đang tuyển</li>
                        <li><i class="fas fa-check"></i>Quyền lợi hấp dẫn</li>
                        <li><i class="fas fa-check"></i>Form ứng tuyển</li>
                        <li><i class="fas fa-check"></i>Upload CV online</li>
                    </ul>
                    <a href="<?= Url::to(['site/contact-recruitment']) ?>" class="contact-btn warning">
                        <i class="fas fa-user-plus"></i>Xem tuyển dụng
                    </a>
                </div>
            </div>
            
            <!-- Quick Contact -->
            <div class="quick-contact">
                <h2 class="section-title">Liên hệ nhanh</h2>
                
                <div class="quick-contact-grid">
                    <div class="quick-item">
                        <div class="quick-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5>Hotline</h5>
                        <p><a href="tel:1900099990">1900.099990</a></p>
                    </div>
                    
                    <div class="quick-item">
                        <div class="quick-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>Email</h5>
                        <p><a href="mailto:info@mammocare.vn">info@mammocare.vn</a></p>
                    </div>
                    
                    <div class="quick-item">
                        <div class="quick-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5>WhatsApp</h5>
                        <p><a href="https://wa.me/84900099990" target="_blank">0948 189 589</a></p>
                    </div>
                    
                    <div class="quick-item">
                        <div class="quick-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5>Giờ làm việc</h5>
                        <p>T2-T7: 7h30-17h00</p>
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="social-section">
                <h2 class="section-title">Kết nối với chúng tôi</h2>
                
                <div class="social-grid">
                    <a href="https://facebook.com/mammocare" target="_blank" class="social-item">
                        <div class="social-icon facebook">
                            <i class="fab fa-facebook-f"></i>
                            </div>
                        <h5>Facebook</h5>
                        <p>Theo dõi tin tức mới nhất</p>
                    </a>
                    
                    <a href="https://youtube.com/mammocare" target="_blank" class="social-item">
                        <div class="social-icon youtube">
                            <i class="fab fa-youtube"></i>
                                </div>
                        <h5>YouTube</h5>
                        <p>Video hướng dẫn và chia sẻ</p>
                    </a>
                    
                    <a href="https://zalo.me/mammocare" target="_blank" class="social-item">
                        <div class="social-icon zalo">
                            <i class="fab fa-zalo"></i>
                                </div>
                        <h5>Zalo</h5>
                        <p>Chat trực tiếp với chúng tôi</p>
                    </a>
                    
                    <a href="https://wa.me/84900099990" target="_blank" class="social-item">
                        <div class="social-icon whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <h5>WhatsApp</h5>
                        <p>Hỗ trợ tư vấn 24/7</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>