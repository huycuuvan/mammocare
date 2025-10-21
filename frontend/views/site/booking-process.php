<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Product;
use backend\models\Supporter;
use backend\models\CatDoctor;

/* @var $this yii\web\View */

$this->title = 'Quy trình khám - Mammocare';
Yii::$app->params['og_description'] = 'Timeline quy trình khám từ đặt lịch đến nhận kết quả tại Mammocare';

// Lấy data từ database
$services = Product::find()
    ->where(['active' => 1])
    ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
    ->limit(3)
    ->all();

// Nếu không có data từ Product, tạo data mẫu
if (empty($services)) {
    $services = [];
    
    // Tạo data mẫu
    $sampleServices = [
        ['id' => 1, 'name' => 'Chụp X-quang tuyến vú 2D', 'brief' => 'Kỹ thuật chụp X-quang 2D chuẩn'],
        ['id' => 2, 'name' => 'Siêu âm tuyến vú', 'brief' => 'Siêu âm tuyến vú không xâm lấn'],
        ['id' => 3, 'name' => 'Sinh thiết tuyến vú', 'brief' => 'Sinh thiết lấy mẫu mô để xét nghiệm']
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

$doctors = Supporter::getAllSupport();
$specialties = CatDoctor::getParent();
?>

<style>
.process-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.process-hero {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
}

.process-hero::before {
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

.process-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: white;
}

.process-hero p {
    font-size: 1.3rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.process-icon {
    position: relative;
    z-index: 2;
}

.process-icon i {
    font-size: 6rem;
    color: rgba(255,255,255,0.3);
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.process-content {
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

.timeline-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.timeline-title {
    font-size: 2rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 2rem;
    text-align: center;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    border-radius: 2px;
}

.timeline-item {
    position: relative;
    margin-bottom: 3rem;
    padding-left: 3rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0.5rem;
    width: 20px;
    height: 20px;
    background: #289cd7;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 0 0 4px #289cd7;
    z-index: 2;
}

.timeline-item.completed::before {
    background: #28a745;
    box-shadow: 0 0 0 4px #28a745;
}

.timeline-item.current::before {
    background: #ffc107;
    box-shadow: 0 0 0 4px #ffc107;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 4px #ffc107; }
    50% { box-shadow: 0 0 0 8px rgba(255,193,7,0.3); }
    100% { box-shadow: 0 0 0 4px #ffc107; }
}

.timeline-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    transition: all 0.3s ease;
    border-left: 4px solid #289cd7;
}

.timeline-card:hover {
    background: #e3f2fd;
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.timeline-card.completed {
    background: #d4edda;
    border-left-color: #28a745;
}

.timeline-card.current {
    background: #fff3cd;
    border-left-color: #ffc107;
}

.timeline-step {
    font-size: 0.9rem;
    font-weight: 700;
    color: #289cd7;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.timeline-card.completed .timeline-step {
    color: #28a745;
}

.timeline-card.current .timeline-step {
    color: #ffc107;
}

.timeline-title-card {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.timeline-description {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.timeline-details {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.timeline-details h5 {
    color: #289cd7;
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.timeline-details ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.timeline-details li {
    display: flex;
    align-items: center;
    margin-bottom: 0.8rem;
    color: #495057;
    font-size: 0.95rem;
}

.timeline-details li i {
    color: #28a745;
    margin-right: 0.8rem;
    font-size: 1rem;
}

.service-cards {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    margin-bottom: 3rem;
}

.service-cards-title {
    font-size: 2rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 2rem;
    text-align: center;
}

.service-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
    border-left: 4px solid #289cd7;
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
    margin-bottom: 1rem;
}

.service-description {
    color: #495057;
    font-size: 0.95rem;
    line-height: 1.6;
}

.info-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.info-title {
    font-size: 2rem;
    font-weight: 800;
    color: #289cd7;
    margin-bottom: 1.5rem;
    text-align: center;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.info-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
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
    margin: 0 auto 1.5rem;
    font-size: 1.5rem;
    color: white;
}

.info-icon.time {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
}

.info-icon.result {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.info-icon.support {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
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

@media (max-width: 768px) {
    .process-hero h1 {
        font-size: 2.5rem;
    }
    
    .process-hero p {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .timeline-section, .service-cards, .info-section {
        padding: 2rem;
    }
    
    .timeline {
        padding-left: 1.5rem;
    }
    
    .timeline-item {
        padding-left: 2.5rem;
    }
    
    .timeline-item::before {
        left: -1.5rem;
    }
    
    .process-icon i {
        font-size: 4rem;
    }
    
    .info-grid {
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
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/booking']) ?>">Đặt lịch khám</a></li>
                <li class="breadcrumb-item active">Quy trình khám</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Process Page -->
<div class="process-page">
    <!-- Hero Section -->
    <section class="process-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1>Quy trình khám</h1>
                    <p>Timeline từ đặt lịch đến nhận kết quả - Hiểu rõ quy trình khám tại Mammocare</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="process-icon">
                        <i class="fas fa-route"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="process-content">
        <div class="container">
            <!-- Timeline Section -->
            <div class="timeline-section">
                <h2 class="timeline-title">Quy trình khám từ A-Z</h2>
                
                <div class="timeline">
                    <!-- Step 1: Booking -->
                    <div class="timeline-item completed">
                        <div class="timeline-card completed">
                            <div class="timeline-step">Bước 1</div>
                            <h3 class="timeline-title-card">Đặt lịch khám</h3>
                            <p class="timeline-description">
                                Chọn dịch vụ, bác sĩ và thời gian phù hợp với bạn. Có thể đặt lịch online, qua hotline hoặc WhatsApp.
                            </p>
                            <div class="timeline-details">
                                <h5>Các cách đặt lịch:</h5>
                                <ul>
                                    <li><i class="fas fa-check"></i>Đặt lịch online 24/7</li>
                                    <li><i class="fas fa-check"></i>Gọi hotline 1900.099990</li>
                                    <li><i class="fas fa-check"></i>Chat qua WhatsApp</li>
                                    <li><i class="fas fa-check"></i>Đến trực tiếp tại phòng khám</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Preparation -->
                    <div class="timeline-item completed">
                        <div class="timeline-card completed">
                            <div class="timeline-step">Bước 2</div>
                            <h3 class="timeline-title-card">Chuẩn bị trước khám</h3>
                            <p class="timeline-description">
                                Nhận hướng dẫn chuẩn bị chi tiết qua email/SMS và chuẩn bị các giấy tờ cần thiết.
                            </p>
                            <div class="timeline-details">
                                <h5>Những gì cần chuẩn bị:</h5>
                                <ul>
                                    <li><i class="fas fa-check"></i>Giấy tờ tùy thân và thẻ BHYT</li>
                                    <li><i class="fas fa-check"></i>Kết quả khám cũ (nếu có)</li>
                                    <li><i class="fas fa-check"></i>Danh sách thuốc đang dùng</li>
                                    <li><i class="fas fa-check"></i>Quần áo thoải mái</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Check-in -->
                    <div class="timeline-item current">
                        <div class="timeline-card current">
                            <div class="timeline-step">Bước 3</div>
                            <h3 class="timeline-title-card">Làm thủ tục đăng ký</h3>
                            <p class="timeline-description">
                                Đến trước giờ hẹn 15-20 phút để làm thủ tục đăng ký và thanh toán tại quầy lễ tân.
                            </p>
                            <div class="timeline-details">
                                <h5>Thủ tục đăng ký:</h5>
                                <ul>
                                    <li><i class="fas fa-check"></i>Xác nhận thông tin cá nhân</li>
                                    <li><i class="fas fa-check"></i>Thanh toán phí khám</li>
                                    <li><i class="fas fa-check"></i>Nhận phiếu khám</li>
                                    <li><i class="fas fa-check"></i>Chờ gọi tên vào khám</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Examination -->
                    <div class="timeline-item">
                        <div class="timeline-card">
                            <div class="timeline-step">Bước 4</div>
                            <h3 class="timeline-title-card">Khám và thực hiện dịch vụ</h3>
                            <p class="timeline-description">
                                Bác sĩ sẽ khám lâm sàng và thực hiện các dịch vụ theo chỉ định (chụp X-quang, siêu âm, sinh thiết...).
                            </p>
                            <div class="timeline-details">
                                <h5>Quá trình khám:</h5>
                                <ul>
                                    <li><i class="fas fa-check"></i>Khám lâm sàng với bác sĩ</li>
                                    <li><i class="fas fa-check"></i>Thực hiện các xét nghiệm cần thiết</li>
                                    <li><i class="fas fa-check"></i>Chụp X-quang/Siêu âm (nếu có)</li>
                                    <li><i class="fas fa-check"></i>Sinh thiết (nếu cần)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Results -->
                    <div class="timeline-item">
                        <div class="timeline-card">
                            <div class="timeline-step">Bước 5</div>
                            <h3 class="timeline-title-card">Nhận kết quả</h3>
                            <p class="timeline-description">
                                Nhận kết quả khám và được bác sĩ tư vấn về tình trạng sức khỏe và phương pháp điều trị (nếu cần).
                            </p>
                            <div class="timeline-details">
                                <h5>Thời gian nhận kết quả:</h5>
                                <ul>
                                    <li><i class="fas fa-check"></i>Kết quả khám lâm sàng: Ngay sau khám</li>
                                    <li><i class="fas fa-check"></i>Kết quả X-quang: 30-60 phút</li>
                                    <li><i class="fas fa-check"></i>Kết quả sinh thiết: 3-5 ngày</li>
                                    <li><i class="fas fa-check"></i>Tư vấn và hướng dẫn điều trị</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Step 6: Follow-up -->
                    <div class="timeline-item">
                        <div class="timeline-card">
                            <div class="timeline-step">Bước 6</div>
                            <h3 class="timeline-title-card">Theo dõi và tái khám</h3>
                            <p class="timeline-description">
                                Được hướng dẫn chăm sóc sau khám và đặt lịch tái khám nếu cần thiết.
                            </p>
                            <div class="timeline-details">
                                <h5>Chăm sóc sau khám:</h5>
                                <ul>
                                    <li><i class="fas fa-check"></i>Hướng dẫn chăm sóc tại nhà</li>
                                    <li><i class="fas fa-check"></i>Đặt lịch tái khám (nếu cần)</li>
                                    <li><i class="fas fa-check"></i>Hỗ trợ tư vấn qua điện thoại</li>
                                    <li><i class="fas fa-check"></i>Cập nhật hồ sơ bệnh án</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Cards -->
            <div class="service-cards">
                <h2 class="service-cards-title">Các dịch vụ khám</h2>
                
                <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <h3 class="service-title"><?= Html::encode($service->name) ?></h3>
                    <p class="service-brief"><?= Html::encode($service->brief) ?></p>
                    <div class="service-description">
                        <?= Html::encode($service->description) ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Additional Info -->
            <div class="info-section">
                <h2 class="info-title">Thông tin bổ sung</h2>
                
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-icon time">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Thời gian khám</h4>
                        <p>Thứ 2 - Thứ 7: 7:30 - 17:00<br>Chủ nhật: 8:00 - 12:00</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon result">
                            <i class="fas fa-file-medical"></i>
                        </div>
                        <h4>Kết quả khám</h4>
                        <p>Nhận kết quả qua email, SMS hoặc đến trực tiếp tại phòng khám</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon support">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>Hỗ trợ 24/7</h4>
                        <p>Hotline: 1900.099990<br>Email: info@mammocare.vn</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>