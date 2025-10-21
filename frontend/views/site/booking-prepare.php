<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Product;
use backend\models\CatDoctor;

/* @var $this yii\web\View */

$this->title = 'Chuẩn bị khám - Mammocare';
Yii::$app->params['og_description'] = 'Hướng dẫn chuẩn bị khám chi tiết cho từng loại dịch vụ tại Mammocare';

// Lấy data từ database
$services = Product::find()
    ->where(['active' => 1])
    ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
    ->limit(4)
    ->all();

// Nếu không có data từ Product, tạo data mẫu
if (empty($services)) {
    $services = [];
    
    // Tạo data mẫu
    $sampleServices = [
        ['id' => 1, 'name' => 'Chụp X-quang tuyến vú 2D', 'brief' => 'Kỹ thuật chụp X-quang 2D chuẩn'],
        ['id' => 2, 'name' => 'Chụp X-quang tuyến vú 3D', 'brief' => 'Kỹ thuật chụp X-quang 3D tiên tiến'],
        ['id' => 3, 'name' => 'Siêu âm tuyến vú', 'brief' => 'Siêu âm tuyến vú không xâm lấn'],
        ['id' => 4, 'name' => 'Sinh thiết tuyến vú', 'brief' => 'Sinh thiết lấy mẫu mô để xét nghiệm']
    ];
    
    foreach($sampleServices as $data) {
        $service = new \stdClass();
        $service->id = $data['id'];
        $service->name = $data['name'];
        $service->brief = $data['brief'];
        $service->description = 'Mô tả chi tiết về ' . $data['name'];
        $services[] = $service;
    }
}

$specialties = CatDoctor::getParent();
?>

<style>
.prepare-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.prepare-hero {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.prepare-hero::before {
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

.prepare-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: white;
}

.prepare-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.prepare-icon {
    position: relative;
    z-index: 2;
}

.prepare-icon i {
    font-size: 6rem;
    color: rgba(255,255,255,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.prepare-content {
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

.service-tabs {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    overflow: hidden;
    margin-bottom: 3rem;
}

.tab-nav {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e9ecef;
}

.tab-nav .nav-tabs {
    border: none;
    margin: 0;
}

.tab-nav .nav-tabs .nav-link {
    border: none;
    background: transparent;
    color: #6c757d;
    font-weight: 600;
    padding: 0.8rem 1.5rem;
    margin-right: 0.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.tab-nav .nav-tabs .nav-link:hover {
    background: rgba(40,156,215,0.1);
    color: #289cd7;
}

.tab-nav .nav-tabs .nav-link.active {
    background: #289cd7;
    color: white;
    box-shadow: 0 4px 15px rgba(40,156,215,0.3);
}

.tab-content {
    padding: 2.5rem;
}

.service-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.service-card:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.service-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #289cd7;
    margin-bottom: 1rem;
}

.service-brief {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.service-description {
    color: #495057;
    font-size: 0.95rem;
    line-height: 1.6;
}

.general-info {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.info-title {
    font-size: 2rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 1.5rem;
    text-align: center;
}

.checklist {
    list-style: none;
    padding: 0;
}

.checklist li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.checklist li:hover {
    background: #e3f2fd;
    transform: translateX(5px);
}

.checklist li i {
    color: #28a745;
    margin-right: 1rem;
    margin-top: 0.2rem;
    font-size: 1.1rem;
}

.checklist li span {
    color: #495057;
    font-size: 1rem;
    line-height: 1.5;
}

.warning-box {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 1px solid #ffc107;
    border-radius: 15px;
    padding: 2rem;
    margin: 2rem 0;
}

.warning-box h4 {
    color: #856404;
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.warning-box h4 i {
    margin-right: 0.8rem;
    font-size: 1.2rem;
}

.warning-box p {
    color: #856404;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    line-height: 1.6;
}

.download-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.download-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #289cd7;
    margin-bottom: 1.5rem;
    text-align: center;
}

.download-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.download-item:hover {
    background: #e3f2fd;
    transform: translateY(-2px);
}

.download-info {
    display: flex;
    align-items: center;
}

.download-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    font-size: 1.2rem;
}

.download-text h5 {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.3rem;
    font-size: 1.1rem;
}

.download-text p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.download-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.8rem 1.5rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.download-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40,167,69,0.3);
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .prepare-hero h1 {
        font-size: 2.5rem;
    }
    
    .prepare-hero p {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .tab-content {
        padding: 1.5rem;
    }
    
    .service-card {
        padding: 1.5rem;
    }
    
    .general-info, .download-section {
        padding: 2rem;
    }
    
    .prepare-icon i {
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
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/booking']) ?>">Đặt lịch khám</a></li>
                <li class="breadcrumb-item active">Chuẩn bị khám</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Prepare Page -->
<div class="prepare-page">
    <!-- Hero Section -->
    <section class="prepare-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Chuẩn bị khám</h1>
                    <p>Hướng dẫn chi tiết để bạn có sự chuẩn bị tốt nhất cho lần khám tại Mammocare</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="prepare-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="prepare-content">
        <div class="container">
            <!-- Service Tabs -->
            <div class="service-tabs">
                <div class="tab-nav">
                    <ul class="nav nav-tabs" id="serviceTabs" role="tablist">
                        <?php foreach ($services as $index => $service): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" 
                                    id="tab-<?= $service->id ?>" 
                                    data-bs-toggle="tab" 
                                    data-bs-target="#service-<?= $service->id ?>" 
                                    type="button" 
                                    role="tab">
                                <?= Html::encode($service->name) ?>
                            </button>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="tab-content" id="serviceTabContent">
                    <?php foreach ($services as $index => $service): ?>
                    <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" 
                         id="service-<?= $service->id ?>" 
                         role="tabpanel">
                        <div class="service-card">
                            <h3 class="service-title"><?= Html::encode($service->name) ?></h3>
                            <p class="service-brief"><?= Html::encode($service->brief) ?></p>
                            <div class="service-description">
                                <?= Html::encode($service->description) ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- General Preparation -->
            <div class="general-info">
                <h2 class="info-title">Chuẩn bị chung</h2>
                
                <ul class="checklist">
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Mang theo giấy tờ tùy thân (CMND/CCCD) và thẻ BHYT (nếu có)</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Mang theo kết quả khám, xét nghiệm cũ (nếu có) để bác sĩ tham khảo</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Mặc quần áo thoải mái, dễ cởi để thuận tiện cho việc khám</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Không sử dụng kem dưỡng da, phấn trang điểm ở vùng ngực</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Đến trước giờ hẹn 15-20 phút để làm thủ tục</span>
                    </li>
                    <li>
                        <i class="fas fa-check"></i>
                        <span>Chuẩn bị danh sách thuốc đang sử dụng (nếu có)</span>
                    </li>
                </ul>

                <div class="warning-box">
                    <h4><i class="fas fa-exclamation-triangle"></i>Lưu ý quan trọng</h4>
                    <p>• Nếu bạn đang mang thai hoặc nghi ngờ có thai, vui lòng thông báo với nhân viên y tế</p>
                    <p>• Nếu bạn có dị ứng với thuốc hoặc chất cản quang, hãy thông báo trước</p>
                    <p>• Trong trường hợp có triệu chứng bất thường, hãy liên hệ ngay với chúng tôi</p>
                </div>
            </div>

            <!-- Download Section -->
            <div class="download-section">
                <h2 class="download-title">Tài liệu hướng dẫn</h2>
                
                <div class="download-item">
                    <div class="download-info">
                        <div class="download-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="download-text">
                            <h5>Hướng dẫn chuẩn bị khám tổng quát</h5>
                            <p>PDF • 2.5 MB • Cập nhật: 15/12/2024</p>
                        </div>
                    </div>
                    <a href="#" class="download-btn">
                        <i class="fas fa-download"></i> Tải về
                    </a>
                </div>

                <div class="download-item">
                    <div class="download-info">
                        <div class="download-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="download-text">
                            <h5>Danh sách kiểm tra trước khám</h5>
                            <p>PDF • 1.8 MB • Cập nhật: 10/12/2024</p>
                        </div>
                    </div>
                    <a href="#" class="download-btn">
                        <i class="fas fa-download"></i> Tải về
                    </a>
                </div>

                <div class="download-item">
                    <div class="download-info">
                        <div class="download-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="download-text">
                            <h5>Hướng dẫn chăm sóc sau khám</h5>
                            <p>PDF • 2.1 MB • Cập nhật: 08/12/2024</p>
                        </div>
                    </div>
                    <a href="#" class="download-btn">
                        <i class="fas fa-download"></i> Tải về
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>