<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\News;
use backend\models\CatNews;

/* @var $this yii\web\View */

$this->title = 'Kiến thức - Mammocare';
Yii::$app->params['og_description'] = 'Kiến thức y khoa về tầm soát và điều trị ung thư vú tại Mammocare';
?>

<style>
.knowledge-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.knowledge-header {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 3rem;
}

.knowledge-header h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: #289cd7;
}

.knowledge-header p {
    font-size: 1.3rem;
    color: #6c757d;
    font-weight: 400;
}

.knowledge-categories {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.category-card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    display: block;
}

.category-card:hover {
    border-color: #289cd7;
    background: #f0f8ff;
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(40,156,215,0.2);
    text-decoration: none;
    color: inherit;
}

.category-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.category-title {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 1rem;
    text-align: center;
}

.category-description {
    color: #6c757d;
    font-size: 1rem;
    text-align: center;
    line-height: 1.6;
}

.category-stats {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    margin-top: 1rem;
    text-align: center;
}

.category-stats .stat-number {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.2rem;
}

.category-stats .stat-label {
    color: #6c757d;
    font-size: 0.9rem;
}

.featured-content {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.featured-title {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    text-align: center;
}

.featured-item {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.featured-item:hover {
    border-color: #289cd7;
    background: #f0f8ff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.featured-item h5 {
    color: #289cd7;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.featured-item p {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.95rem;
}

@media (max-width: 768px) {
    .knowledge-header h1 {
        font-size: 2.2rem;
    }
    
    .knowledge-header p {
        font-size: 1.1rem;
    }
    
    .knowledge-categories, .featured-content {
        padding: 1.5rem;
    }
    
    .category-card {
        padding: 1.5rem;
    }
    
    .category-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .category-title {
        font-size: 1.2rem;
    }
}
</style>

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::home() ?>">Trang chủ</a></li>
                <li class="breadcrumb-item active">Kiến thức</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Knowledge Page -->
<section class="knowledge-page py-5">
    <div class="container">
        <div class="knowledge-header text-center mb-5">
            <h1 class="mb-3">Kiến thức Y khoa</h1>
            <p class="text-muted">Cập nhật kiến thức về tầm soát, phòng ngừa và điều trị ung thư vú</p>
        </div>

        <!-- Knowledge Categories -->
        <div class="knowledge-categories">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <a href="<?= Url::to(['site/knowledge-news']) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h3 class="category-title">Tin tức</h3>
                        <p class="category-description">Cập nhật tin tức y khoa mới nhất về ung thư vú và các phương pháp điều trị</p>
                        <div class="category-stats">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">bài viết</span>
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <a href="<?= Url::to(['site/knowledge-qa']) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3 class="category-title">Hỏi đáp</h3>
                        <p class="category-description">Giải đáp thắc mắc về mang thai, tầm soát, điều trị và phòng ngừa ung thư vú</p>
                        <div class="category-stats">
                            <span class="stat-number">100+</span>
                            <span class="stat-label">câu hỏi</span>
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <a href="<?= Url::to(['site/knowledge-self-check']) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3 class="category-title">Tự khám</h3>
                        <p class="category-description">Hướng dẫn chi tiết cách tự khám vú tại nhà với hình ảnh và video</p>
                        <div class="category-stats">
                            <span class="stat-number">5</span>
                            <span class="stat-label">bước</span>
                        </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <a href="<?= Url::to(['site/knowledge-downloads']) ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <h3 class="category-title">Tài liệu</h3>
                        <p class="category-description">Tải về brochure, hướng dẫn chuẩn bị và tài liệu chuyên môn</p>
                        <div class="category-stats">
                            <span class="stat-number">20+</span>
                            <span class="stat-label">tài liệu</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Featured Content -->
        <div class="featured-content">
            <h2 class="featured-title">Nội dung nổi bật</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="featured-item">
                        <h5><i class="fas fa-star me-2 text-warning"></i>Khi nào nên bắt đầu tầm soát ung thư vú?</h5>
                        <p>Tìm hiểu về độ tuổi và tần suất tầm soát phù hợp với từng đối tượng...</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="featured-item">
                        <h5><i class="fas fa-star me-2 text-warning"></i>Hướng dẫn tự khám vú tại nhà</h5>
                        <p>5 bước đơn giản để tự khám vú và phát hiện sớm các dấu hiệu bất thường...</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="featured-item">
                        <h5><i class="fas fa-star me-2 text-warning"></i>Mang thai và ung thư vú</h5>
                        <p>Những điều cần biết về việc mang thai sau điều trị ung thư vú...</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="featured-item">
                        <h5><i class="fas fa-star me-2 text-warning"></i>Chế độ ăn uống phòng ngừa</h5>
                        <p>Thực phẩm và chế độ dinh dưỡng giúp giảm nguy cơ ung thư vú...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="featured-content">
            <h2 class="featured-title">Liên kết nhanh</h2>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="<?= Url::to(['site/knowledge-qa', 'category' => 'mang-thai-ung-thu-vu']) ?>" class="btn btn-outline-primary w-100">
                        <i class="fas fa-baby me-2"></i>Mang thai & Ung thư vú
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="<?= Url::to(['site/knowledge-qa', 'category' => 'tam-soat']) ?>" class="btn btn-outline-primary w-100">
                        <i class="fas fa-search me-2"></i>Tầm soát
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="<?= Url::to(['site/knowledge-qa', 'category' => 'phong-ngua']) ?>" class="btn btn-outline-primary w-100">
                        <i class="fas fa-shield-alt me-2"></i>Phòng ngừa
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
