<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Chi nhánh Hà Nội - Mammocare';
Yii::$app->params['og_description'] = 'Chi nhánh Mammocare tại Hà Nội - 243 Đường Giải Phóng, Quận Đống Đa - Dịch vụ chuyên khoa tuyến vú';
?>

<style>
.branch-detail-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.branch-hero {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.branch-hero::before {
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

.branch-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: white;
}

.branch-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.branch-icon {
    position: relative;
    z-index: 2;
}

.branch-icon i {
    font-size: 6rem;
    color: rgba(255,255,255,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.branch-content {
    padding: 4rem 0;
}

.info-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.section-title {
    font-size: 2rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 2rem;
    text-align: center;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.info-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    border-left: 4px solid #289cd7;
}

.info-card:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.info-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.5rem;
    color: white;
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

.info-card h4 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}

.info-card p {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

.map-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.map-container {
    position: relative;
    width: 100%;
    height: 400px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.map-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #6c757d;
}

.map-placeholder i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #289cd7;
}

.map-placeholder h4 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.map-placeholder p {
    font-size: 1rem;
    margin: 0;
}

.directions-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.directions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.direction-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    border-left: 4px solid #28a745;
}

.direction-card:hover {
    background: #d4edda;
    transform: translateY(-5px);
}

.direction-icon {
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

.direction-card h5 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.direction-card p {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0;
}

.team-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.team-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
}

.team-card:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
}

.team-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: white;
}

.team-card h5 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.team-card p {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.cta-section {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    color: white;
    margin-bottom: 3rem;
}

.cta-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 1rem;
}

.cta-description {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-btn {
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: 2px solid white;
    min-width: 150px;
    justify-content: center;
}

.cta-btn.primary {
    background: white;
    color: #289cd7;
}

.cta-btn.secondary {
    background: transparent;
    color: white;
}

.cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: #289cd7;
    text-decoration: none;
}

.cta-btn.secondary:hover {
    background: white;
    color: #289cd7;
}

@media (max-width: 768px) {
    .branch-hero h1 {
        font-size: 2.5rem;
    }
    
    .branch-hero p {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .info-section, .map-section, .directions-section, .team-section, .cta-section {
        padding: 2rem;
    }
    
    .branch-icon i {
        font-size: 4rem;
    }
    
    .info-grid, .directions-grid, .team-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-buttons {
        flex-direction: column;
    }
    
    .cta-btn {
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
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/branches']) ?>">Chi nhánh</a></li>
                <li class="breadcrumb-item active">Hà Nội</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Branch Detail Page -->
<div class="branch-detail-page">
    <!-- Hero Section -->
    <section class="branch-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Chi nhánh Hà Nội</h1>
                    <p>Trụ sở chính Mammocare tại Hà Nội - Phục vụ khách hàng với chất lượng tốt nhất</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="branch-icon">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="branch-content">
        <div class="container">
            <!-- Contact Information -->
            <div class="info-section">
                <h2 class="section-title">Thông tin liên hệ</h2>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-icon address">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Địa chỉ</h4>
                        <p>243 Đường Giải Phóng, Phường Phương Mai, Quận Đống Đa, Thành Phố Hà Nội</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon phone">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Điện thoại</h4>
                        <p>1900.099990<br>0948 189 589</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon email">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email</h4>
                        <p>info@mammocare.vn</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon time">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Giờ làm việc</h4>
                        <p>Thứ 2 - Thứ 7<br>7h30 - 17h00</p>
                    </div>
                </div>
            </div>
            
            <!-- Map Section -->
            <div class="map-section">
                <h2 class="section-title">Vị trí trên bản đồ</h2>
                <div class="map-container">
                    <div class="map-placeholder">
                        <i class="fas fa-map"></i>
                        <h4>Google Maps</h4>
                        <p>243 Đường Giải Phóng, Phường Phương Mai, Quận Đống Đa, Hà Nội</p>
                    </div>
                </div>
            </div>
            
            <!-- Directions Section -->
            <div class="directions-section">
                <h2 class="section-title">Hướng dẫn đi lại</h2>
                
                <div class="directions-grid">
                    <div class="direction-card">
                        <div class="direction-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h5>Bằng ô tô</h5>
                        <p>Từ trung tâm Hà Nội, đi theo đường Giải Phóng về phía Nam, chi nhánh nằm bên tay phải</p>
                    </div>
                    
                    <div class="direction-card">
                        <div class="direction-icon">
                            <i class="fas fa-bus"></i>
                        </div>
                        <h5>Bằng xe bus</h5>
                        <p>Tuyến 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20</p>
                    </div>
                    
                    <div class="direction-card">
                        <div class="direction-icon">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <h5>Bằng xe máy</h5>
                        <p>Thuận tiện di chuyển, có chỗ để xe rộng rãi và an toàn</p>
                    </div>
                    
                    <div class="direction-card">
                        <div class="direction-icon">
                            <i class="fas fa-taxi"></i>
                        </div>
                        <h5>Bằng taxi</h5>
                        <p>Gọi taxi đến địa chỉ: 243 Đường Giải Phóng, Quận Đống Đa, Hà Nội</p>
                    </div>
                </div>
            </div>
            
            <!-- Team Section -->
            <div class="team-section">
                <h2 class="section-title">Đội ngũ tại chi nhánh</h2>
                
                <div class="team-grid">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h5>Bác sĩ chuyên khoa</h5>
                        <p>5+ bác sĩ giàu kinh nghiệm</p>
                    </div>
                    
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-user-nurse"></i>
                        </div>
                        <h5>Y tá điều dưỡng</h5>
                        <p>10+ y tá chuyên nghiệp</p>
                    </div>
                    
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5>Nhân viên tư vấn</h5>
                        <p>3+ tư vấn viên chuyên nghiệp</p>
                    </div>
                    
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <h5>Kỹ thuật viên</h5>
                        <p>8+ kỹ thuật viên chuyên môn</p>
                    </div>
                </div>
            </div>
            
            <!-- CTA Section -->
            <div class="cta-section">
                <h2 class="cta-title">Đặt lịch khám ngay</h2>
                <p class="cta-description">Liên hệ với chúng tôi để được tư vấn và đặt lịch khám phù hợp</p>
                
                <div class="cta-buttons">
                    <a href="<?= Url::to(['site/booking']) ?>" class="cta-btn primary">
                        <i class="fas fa-calendar-plus"></i>Đặt lịch online
                    </a>
                    <a href="tel:1900099990" class="cta-btn secondary">
                        <i class="fas fa-phone"></i>Gọi hotline
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
