<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Thông tin liên hệ - Mammocare';
Yii::$app->params['og_description'] = 'Thông tin liên hệ chi tiết của Mammocare - Hotline, email, địa chỉ các chi nhánh tại Hà Nội và Nghệ An';
?>

<style>
.contact-info-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.contact-info-hero {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.contact-info-hero::before {
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

.contact-info-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: white;
}

.contact-info-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.contact-info-icon {
    position: relative;
    z-index: 2;
}

.contact-info-icon i {
    font-size: 6rem;
    color: rgba(255,255,255,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.contact-info-content {
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

.branches-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.branches-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 3rem;
    margin-top: 2rem;
}

.branch-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2.5rem;
    transition: all 0.3s ease;
    border-left: 4px solid #289cd7;
}

.branch-card:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.branch-header {
    text-align: center;
    margin-bottom: 2rem;
}

.branch-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.branch-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.branch-subtitle {
    color: #289cd7;
    font-weight: 600;
    font-size: 1rem;
}

.branch-info {
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: #f0f8ff;
    transform: translateX(5px);
}

.info-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.info-icon.address {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.info-icon.phone {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.info-icon.email {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.info-icon.time {
    background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
}

.info-content h6 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.3rem;
    font-size: 0.95rem;
}

.info-content p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.5;
}

.branch-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.branch-btn {
    padding: 0.7rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    min-width: 120px;
    justify-content: center;
}

.branch-btn.primary {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    color: white;
}

.branch-btn.secondary {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.branch-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    color: white;
    text-decoration: none;
}

.contact-form-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.form-title {
    font-size: 2rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 1.5rem;
    text-align: center;
}

.contact-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.form-control:focus {
    border-color: #289cd7;
    box-shadow: 0 0 0 0.2rem rgba(40,156,215,0.15);
    background: white;
    outline: none;
}

.form-control::placeholder {
    color: #adb5bd;
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.submit-btn {
    width: 100%;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.3);
}

.quick-contact-section {
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
    border-left: 4px solid #28a745;
}

.quick-item:hover {
    background: #d4edda;
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
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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

@media (max-width: 768px) {
    .contact-info-hero h1 {
        font-size: 2.5rem;
    }
    
    .contact-info-hero p {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .branches-section, .contact-form-section, .quick-contact-section {
        padding: 2rem;
    }
    
    .contact-info-icon i {
        font-size: 4rem;
    }
    
    .branches-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-contact-grid {
        grid-template-columns: 1fr;
    }
    
    .branch-actions {
        flex-direction: column;
    }
    
    .branch-btn {
        width: 100%;
    }
}
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::home() ?>">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/contact']) ?>">Liên hệ</a></li>
                <li class="breadcrumb-item active">Thông tin liên hệ</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Contact Info Page -->
<div class="contact-info-page">
    <!-- Hero Section -->
    <section class="contact-info-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Thông tin liên hệ</h1>
                    <p>Thông tin chi tiết về các chi nhánh và cách thức liên hệ với Mammocare</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="contact-info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="contact-info-content">
        <div class="container">
            <!-- Branches Section -->
            <div class="branches-section">
                <h2 class="section-title">Thông tin các chi nhánh</h2>
                
                <div class="branches-grid">
                    <!-- Hà Nội Branch -->
                    <div class="branch-card">
                        <div class="branch-header">
                            <div class="branch-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3 class="branch-title">Chi nhánh Hà Nội</h3>
                            <p class="branch-subtitle">Trụ sở chính</p>
                        </div>
                        
                        <div class="branch-info">
                            <div class="info-item">
                                <div class="info-icon address">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Địa chỉ</h6>
                                    <p>243 Đường Giải Phóng, Phường Phương Mai, Quận Đống Đa, Thành Phố Hà Nội</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon phone">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Điện thoại</h6>
                                    <p>1900.099990 - 0948 189 589</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon email">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Email</h6>
                                    <p>info@mammocare.vn</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon time">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Giờ làm việc</h6>
                                    <p>Thứ 2 - Thứ 7: 7h30 - 17h00</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="branch-actions">
                            <a href="<?= Url::to(['site/branch-detail', 'city' => 'ha-noi']) ?>" class="branch-btn primary">
                                <i class="fas fa-info-circle"></i>Chi tiết
                            </a>
                            <a href="https://maps.google.com/?q=243+Đường+Giải+Phóng,+Phường+Phương+Mai,+Quận+Đống+Đa,+Hà+Nội" target="_blank" class="branch-btn secondary">
                                <i class="fas fa-directions"></i>Chỉ đường
                            </a>
                        </div>
                    </div>
                    
                    <!-- Nghệ An Branch -->
                    <div class="branch-card">
                        <div class="branch-header">
                            <div class="branch-icon">
                                <i class="fas fa-hospital"></i>
                            </div>
                            <h3 class="branch-title">Chi nhánh Nghệ An</h3>
                            <p class="branch-subtitle">Chi nhánh tại Bệnh viện 115</p>
                        </div>
                        
                        <div class="branch-info">
                            <div class="info-item">
                                <div class="info-icon address">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Địa chỉ</h6>
                                    <p>Tầng 2, BV Ngoại khoa 115 Nghệ An, số 40 – Đại lộ Xô Viết Nghệ Tĩnh – TP Vinh</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon phone">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Điện thoại</h6>
                                    <p>1900.099990 - 0944 198 598</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon email">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Email</h6>
                                    <p>info@mammocare.vn</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon time">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Giờ làm việc</h6>
                                    <p>Thứ 2 - Thứ 7: 7h30 - 17h00</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="branch-actions">
                            <a href="<?= Url::to(['site/branch-detail', 'city' => 'nghe-an']) ?>" class="branch-btn primary">
                                <i class="fas fa-info-circle"></i>Chi tiết
                            </a>
                            <a href="https://maps.google.com/?q=Tầng+2,+BV+Ngoại+khoa+115+Nghệ+An,+số+40+–+Đại+lộ+Xô+Viết+Nghệ+Tĩnh+–+TP+Vinh" target="_blank" class="branch-btn secondary">
                                <i class="fas fa-directions"></i>Chỉ đường
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="contact-form-section">
                <h2 class="form-title">Gửi tin nhắn cho chúng tôi</h2>
                
                <form class="contact-form" action="<?= Url::to(['site/contact']) ?>" method="post">
                    <div class="form-group">
                        <label class="form-label" for="full_name">Họ và tên *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Nhập họ và tên của bạn" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập địa chỉ email của bạn" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">Số điện thoại *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="subject">Chủ đề</label>
                        <select class="form-control" id="subject" name="subject">
                            <option value="">Chọn chủ đề</option>
                            <option value="booking">Đặt lịch khám</option>
                            <option value="consultation">Tư vấn</option>
                            <option value="complaint">Khiếu nại</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="message">Nội dung *</label>
                        <textarea class="form-control" id="message" name="message" placeholder="Nhập nội dung tin nhắn của bạn" required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i>Gửi tin nhắn
                    </button>
                </form>
            </div>
            
            <!-- Quick Contact -->
            <div class="quick-contact-section">
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
        </div>
    </section>
</div>
