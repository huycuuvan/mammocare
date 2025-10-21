<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\News;
use backend\models\CatNews;

/* @var $this yii\web\View */

$this->title = 'Tin tức - Kiến thức Y khoa - Mammocare';
Yii::$app->params['og_description'] = 'Tin tức y khoa mới nhất về tầm soát và điều trị ung thư vú';

// Lấy data từ database
$newsList = News::find()
    ->where(['active' => 1])
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(12)
    ->all();

$categories = CatNews::getParent();
?>

<style>
.news-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.news-header {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 3rem;
}

.news-header h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: #289cd7;
}

.news-header p {
    font-size: 1.3rem;
    color: #6c757d;
    font-weight: 400;
}

.news-filters {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.filter-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.filter-tab {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 25px;
    padding: 0.8rem 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: #6c757d;
    font-weight: 600;
}

.filter-tab:hover, .filter-tab.active {
    background: #289cd7;
    border-color: #289cd7;
    color: white;
    text-decoration: none;
}

.search-box {
    position: relative;
}

.search-box input {
    border: 2px solid #e9ecef;
    border-radius: 25px;
    padding: 1rem 1.5rem 1rem 3rem;
    width: 100%;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-box input:focus {
    border-color: #289cd7;
    box-shadow: 0 0 0 0.2rem rgba(40,156,215,0.15);
    outline: none;
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.news-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    cursor: pointer;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(40,156,215,0.2);
}

.news-image {
    height: 200px;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
}

.news-content {
    padding: 1.5rem;
}

.news-category {
    background: #e3f2fd;
    color: #289cd7;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 1rem;
}

.news-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 0.8rem;
    line-height: 1.4;
}

.news-excerpt {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.news-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #6c757d;
    font-size: 0.85rem;
}

.news-date {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.news-read-more {
    color: #289cd7;
    font-weight: 600;
    text-decoration: none;
}

.news-read-more:hover {
    color: #1e7bb8;
    text-decoration: none;
}

.load-more {
    text-align: center;
}

.load-more-btn {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    border: none;
    border-radius: 25px;
    padding: 1rem 2.5rem;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40,156,215,0.3);
}

.load-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.4);
    color: white;
}

@media (max-width: 768px) {
    .news-header h1 {
        font-size: 2.2rem;
    }
    
    .news-header p {
        font-size: 1.1rem;
    }
    
    .news-filters {
        padding: 1.5rem;
    }
    
    .filter-tabs {
        justify-content: center;
    }
    
    .news-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .news-card {
        margin-bottom: 1rem;
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
                <li class="breadcrumb-item active">Tin tức</li>
            </ol>
        </nav>
    </div>
</section>

<!-- News Page -->
<section class="news-page py-5">
    <div class="container">
        <div class="news-header text-center mb-5">
            <h1 class="mb-3">Tin tức Y khoa</h1>
            <p class="text-muted">Cập nhật tin tức mới nhất về tầm soát và điều trị ung thư vú</p>
        </div>

        <!-- Filters -->
        <div class="news-filters">
            <div class="filter-tabs">
                <a href="<?= Url::to(['site/knowledge-news']) ?>" class="filter-tab active">Tất cả</a>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <a href="<?= Url::to(['site/knowledge-news', 'category' => $category->id]) ?>" class="filter-tab">
                            <?= $category->name ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Tìm kiếm tin tức..." id="news-search">
            </div>
        </div>

        <!-- News Grid -->
        <div class="news-grid" id="news-grid">
            <?php if (!empty($newsList)): ?>
                <?php foreach ($newsList as $news): ?>
                    <div class="news-card" data-title="<?= strtolower($news->title) ?>">
                        <div class="news-image">
                            <?php if (!empty($news->path)): ?>
                                <img src="<?= $news->path ?>" alt="<?= $news->title ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fas fa-newspaper"></i>
                            <?php endif; ?>
                        </div>
                        <div class="news-content">
                            <div class="news-category">
                                <?= $news->father ? $news->father->name : 'Tin tức' ?>
                            </div>
                            <h3 class="news-title"><?= $news->title ?></h3>
                            <p class="news-excerpt">
                                <?= strip_tags(substr($news->brief, 0, 120)) ?>...
                            </p>
                            <div class="news-meta">
                                <div class="news-date">
                                    <i class="fas fa-calendar"></i>
                                    <?= date('d/m/Y', strtotime($news->created_at)) ?>
                                </div>
                                <a href="<?= $news->getUrl() ?>" class="news-read-more">
                                    Đọc thêm <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Chưa có tin tức nào. Vui lòng quay lại sau.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Load More -->
        <div class="load-more">
            <button class="load-more-btn" onclick="loadMoreNews()">
                <i class="fas fa-plus me-2"></i>Tải thêm tin tức
            </button>
        </div>
    </div>
</section>

<script>
let currentPage = 1;
let isLoading = false;

// Search functionality
document.getElementById('news-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const newsCards = document.querySelectorAll('.news-card');
    
    newsCards.forEach(card => {
        const title = card.getAttribute('data-title');
        if (title.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Load more news
function loadMoreNews() {
    if (isLoading) return;
    
    isLoading = true;
    currentPage++;
    
    // Simulate loading more news
    const loadMoreBtn = document.querySelector('.load-more-btn');
    const originalText = loadMoreBtn.innerHTML;
    loadMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang tải...';
    loadMoreBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // In real implementation, you would make an AJAX call here
        // For now, we'll just show a message
        loadMoreBtn.innerHTML = '<i class="fas fa-check me-2"></i>Đã tải hết';
        loadMoreBtn.disabled = true;
        
        // Show message
        const message = document.createElement('div');
        message.className = 'alert alert-info mt-3';
        message.innerHTML = '<i class="fas fa-info-circle me-2"></i>Đã hiển thị tất cả tin tức';
        document.querySelector('.load-more').appendChild(message);
        
        isLoading = false;
    }, 1500);
}

// Category filter
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all tabs
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // In real implementation, you would filter news by category here
        // For now, we'll just scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>
