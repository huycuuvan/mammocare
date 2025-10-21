<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Hướng dẫn Tự khám - Kiến thức Y khoa - Mammocare';
Yii::$app->params['og_description'] = 'Hướng dẫn chi tiết cách tự khám vú tại nhà với hình ảnh và video';
?>

<style>
.self-check-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.self-check-header {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 3rem;
}

.self-check-header h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: #289cd7;
}

.self-check-header p {
    font-size: 1.3rem;
    color: #6c757d;
    font-weight: 400;
}

.warning-box {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    border: 2px solid #ffc107;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: center;
}

.warning-box h3 {
    color: #856404;
    font-weight: 700;
    margin-bottom: 1rem;
}

.warning-box p {
    color: #856404;
    font-size: 1.1rem;
    margin: 0;
}

.steps-container {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.step-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 3rem;
    padding: 2rem;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.step-item:hover {
    border-color: #289cd7;
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.step-number {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.5rem;
    margin-right: 2rem;
    flex-shrink: 0;
}

.step-content {
    flex: 1;
}

.step-title {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 1rem;
}

.step-description {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.step-image {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #289cd7;
    font-size: 3rem;
    margin-left: 2rem;
    flex-shrink: 0;
}

.step-tips {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    margin-top: 1rem;
}

.step-tips h5 {
    color: #289cd7;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.step-tips ul {
    margin: 0;
    padding-left: 1.5rem;
}

.step-tips li {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 0.3rem;
}

.video-section {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    text-align: center;
}

.video-title {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
}

.video-placeholder {
    width: 100%;
    max-width: 600px;
    height: 300px;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 4rem;
    margin: 0 auto 1rem;
}

.download-section {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.download-title {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    text-align: center;
}

.download-item {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.3s ease;
}

.download-item:hover {
    border-color: #289cd7;
    background: #f0f8ff;
}

.download-info h5 {
    color: #289cd7;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.download-info p {
    color: #6c757d;
    margin: 0;
    font-size: 0.95rem;
}

.download-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 25px;
    padding: 0.8rem 1.5rem;
    color: white;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.download-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40,167,69,0.3);
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .self-check-header h1 {
        font-size: 2.2rem;
    }
    
    .self-check-header p {
        font-size: 1.1rem;
    }
    
    .steps-container, .video-section, .download-section {
        padding: 1.5rem;
    }
    
    .step-item {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
    }
    
    .step-number {
        margin: 0 auto 1rem;
    }
    
    .step-image {
        margin: 1rem auto 0;
    }
    
    .download-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::home() ?>">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/knowledge']) ?>">Kiến thức</a></li>
                <li class="breadcrumb-item active">Hướng dẫn Tự khám</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Self Check Page -->
<section class="self-check-page py-5">
    <div class="container">
        <div class="self-check-header text-center mb-5">
            <h1 class="mb-3">Hướng dẫn Tự khám</h1>
            <p class="text-muted">5 bước đơn giản để tự khám vú tại nhà</p>
        </div>

        <!-- Warning Box -->
        <div class="warning-box">
            <h3><i class="fas fa-exclamation-triangle me-2"></i>Lưu ý quan trọng</h3>
            <p><strong>Tự khám vú không thay thế việc khám chuyên khoa định kỳ!</strong><br>
            Nếu phát hiện bất kỳ dấu hiệu bất thường nào, hãy đến gặp bác sĩ ngay lập tức.</p>
        </div>

        <!-- Steps -->
        <div class="steps-container">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3 class="step-title">Chuẩn bị</h3>
                    <p class="step-description">
                        Thực hiện tự khám vào cùng một thời điểm mỗi tháng, tốt nhất là 3-5 ngày sau khi hết kinh. 
                        Đứng trước gương trong phòng có ánh sáng tốt, cởi bỏ áo ngực và áo.
                    </p>
                    <div class="step-tips">
                        <h5><i class="fas fa-lightbulb me-2"></i>Mẹo:</h5>
                        <ul>
                            <li>Chọn thời điểm vú không căng tức</li>
                            <li>Đảm bảo có đủ ánh sáng</li>
                            <li>Thư giãn và tập trung</li>
                        </ul>
                    </div>
                </div>
                <div class="step-image">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3 class="step-title">Quan sát trước gương</h3>
                    <p class="step-description">
                        Đứng thẳng, hai tay buông xuôi. Quan sát kỹ hình dạng, kích thước và màu sắc của vú. 
                        Sau đó đưa hai tay lên đầu và quan sát lại. Cuối cùng, chống tay vào hông và nghiêng người về phía trước.
                    </p>
                    <div class="step-tips">
                        <h5><i class="fas fa-lightbulb me-2"></i>Chú ý:</h5>
                        <ul>
                            <li>Da có bị lõm, nhăn nheo không?</li>
                            <li>Núm vú có bị thụt vào trong không?</li>
                            <li>Có sự khác biệt giữa hai bên vú không?</li>
                        </ul>
                    </div>
                </div>
                <div class="step-image">
                    <i class="fas fa-eye"></i>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3 class="step-title">Kiểm tra núm vú</h3>
                    <p class="step-description">
                        Nhẹ nhàng bóp núm vú để kiểm tra xem có dịch tiết ra không. 
                        Quan sát màu sắc và tính chất của dịch (nếu có). 
                        Bình thường không có dịch tiết hoặc chỉ có một chút dịch trong suốt.
                    </p>
                    <div class="step-tips">
                        <h5><i class="fas fa-lightbulb me-2"></i>Cảnh báo:</h5>
                        <ul>
                            <li>Dịch có máu hoặc màu đỏ</li>
                            <li>Dịch có mùi hôi</li>
                            <li>Núm vú bị đau hoặc ngứa</li>
                        </ul>
                    </div>
                </div>
                <div class="step-image">
                    <i class="fas fa-hand-paper"></i>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3 class="step-title">Khám bằng tay khi đứng</h3>
                    <p class="step-description">
                        Đưa tay phải lên đầu, dùng 3 ngón tay giữa của tay trái để khám vú phải. 
                        Bắt đầu từ vùng nách, di chuyển theo hình xoắn ốc từ ngoài vào trong. 
                        Dùng áp lực nhẹ, vừa và mạnh để cảm nhận các lớp mô khác nhau.
                    </p>
                    <div class="step-tips">
                        <h5><i class="fas fa-lightbulb me-2"></i>Kỹ thuật:</h5>
                        <ul>
                            <li>Dùng phần phẳng của ngón tay</li>
                            <li>Không nhấc tay khỏi da</li>
                            <li>Khám toàn bộ vú và vùng nách</li>
                        </ul>
                    </div>
                </div>
                <div class="step-image">
                    <i class="fas fa-hand-paper"></i>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">5</div>
                <div class="step-content">
                    <h3 class="step-title">Khám khi nằm</h3>
                    <p class="step-description">
                        Nằm ngửa, đặt một chiếc gối nhỏ dưới vai phải và đưa tay phải lên đầu. 
                        Dùng tay trái khám vú phải theo cùng cách như khi đứng. 
                        Lặp lại với vú trái. Tư thế nằm giúp mô vú dàn đều và dễ phát hiện bất thường hơn.
                    </p>
                    <div class="step-tips">
                        <h5><i class="fas fa-lightbulb me-2"></i>Lưu ý:</h5>
                        <ul>
                            <li>Đảm bảo khám cả vùng nách</li>
                            <li>Kiểm tra từ trên xuống dưới</li>
                            <li>Ghi chép lại những gì phát hiện</li>
                        </ul>
                    </div>
                </div>
                <div class="step-image">
                    <i class="fas fa-bed"></i>
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div class="video-section">
            <h2 class="video-title"><i class="fas fa-play-circle me-2"></i>Video hướng dẫn</h2>
            <div class="video-placeholder">
                <i class="fas fa-play"></i>
            </div>
            <p class="text-muted">Video hướng dẫn chi tiết cách tự khám vú (Sẽ được cập nhật)</p>
        </div>

        <!-- Download Section -->
        <div class="download-section">
            <h2 class="download-title"><i class="fas fa-download me-2"></i>Tài liệu tải về</h2>
            
            <div class="download-item">
                <div class="download-info">
                    <h5><i class="fas fa-file-pdf me-2"></i>Hướng dẫn tự khám vú (PDF)</h5>
                    <p>Tài liệu chi tiết với hình ảnh minh họa từng bước tự khám</p>
                </div>
                <a href="#" class="download-btn">
                    <i class="fas fa-download me-2"></i>Tải về
                </a>
            </div>

            <div class="download-item">
                <div class="download-info">
                    <h5><i class="fas fa-file-pdf me-2"></i>Checklist tự khám</h5>
                    <p>Danh sách kiểm tra để đảm bảo không bỏ sót bước nào</p>
                </div>
                <a href="#" class="download-btn">
                    <i class="fas fa-download me-2"></i>Tải về
                </a>
            </div>

            <div class="download-item">
                <div class="download-info">
                    <h5><i class="fas fa-file-pdf me-2"></i>Dấu hiệu cảnh báo</h5>
                    <p>Danh sách các dấu hiệu cần đến gặp bác sĩ ngay</p>
                </div>
                <a href="#" class="download-btn">
                    <i class="fas fa-download me-2"></i>Tải về
                </a>
            </div>
        </div>
    </div>
</section>
