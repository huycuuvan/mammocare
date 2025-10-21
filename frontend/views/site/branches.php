<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Chi nhánh - Mammocare';
Yii::$app->params['og_description'] = 'Danh sách các chi nhánh Mammocare tại Hà Nội và Nghệ An - Dịch vụ chuyên khoa tuyến vú';
?>

<style>
.branches-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.branches-hero {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.branches-hero::before {
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

.branches-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: white;
}

.branches-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.branches-icon {
    position: relative;
    z-index: 2;
}

.branches-icon i {
    font-size: 6rem;
    color: rgba(255,255,255,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.branches-content {
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

.branch-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.branch-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(40,156,215,0.15);
}

.branch-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.branch-header {
    text-align: center;
    margin-bottom: 2rem;
}

.branch-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.branch-title {
    font-size: 1.8rem;
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
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: #e3f2fd;
    transform: translateX(5px);
}

.info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.1rem;
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

.info-content h5 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.3rem;
    font-size: 1rem;
}

.info-content p {
    color: #6c757d;
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.5;
}

.branch-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.branch-btn {
    padding: 0.8rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    min-width: 150px;
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
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    color: white;
    text-decoration: none;
}

.map-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-top: 3rem;
}

.map-title {
    font-size: 2rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 1.5rem;
    text-align: center;
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

@media (max-width: 768px) {
    .branches-hero h1 {
        font-size: 2.5rem;
    }
    
    .branches-hero p {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .branch-card {
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .branches-icon i {
        font-size: 4rem;
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
                <li class="breadcrumb-item active">Chi nhánh</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Branches Page -->
<div class="branches-page">
    <!-- Hero Section -->
    <section class="branches-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Chi nhánh</h1>
                    <p>Khám phá các chi nhánh Mammocare tại Hà Nội và Nghệ An - Phục vụ bạn với chất lượng tốt nhất</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="branches-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="branches-content">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Các chi nhánh của chúng tôi</h2>
                <p class="section-subtitle">Mammocare có mặt tại 2 thành phố lớn để phục vụ bạn tốt nhất</p>
            </div>
            
            <div class="row g-4">
                <!-- Hà Nội Branch -->
                <div class="col-lg-6">
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
                                    <h5>Địa chỉ</h5>
                                    <p>243 Đường Giải Phóng, Phường Phương Mai, Quận Đống Đa, Thành Phố Hà Nội</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon phone">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Điện thoại</h5>
                                    <p>1900.099990 - 0948 189 589</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon email">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Email</h5>
                                    <p>info@mammocare.vn</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon time">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Giờ làm việc</h5>
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
                </div>
                
                <!-- Nghệ An Branch -->
                <div class="col-lg-6">
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
                                    <h5>Địa chỉ</h5>
                                    <p>Tầng 2, BV Ngoại khoa 115 Nghệ An, số 40 – Đại lộ Xô Viết Nghệ Tĩnh – TP Vinh</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon phone">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Điện thoại</h5>
                                    <p>1900.099990 - 0944 198 598</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon email">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Email</h5>
                                    <p>info@mammocare.vn</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon time">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <h5>Giờ làm việc</h5>
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
            
            <!-- Map Section -->
            <div class="map-section">
                <h2 class="map-title">Bản đồ các chi nhánh</h2>
                <div class="map-container">
                    <div class="map-placeholder">
                        <i class="fas fa-map"></i>
                        <h4>Google Maps</h4>
                        <p>Bản đồ tương tác hiển thị vị trí các chi nhánh</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
