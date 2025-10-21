<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Tài liệu Tải về - Kiến thức Y khoa - Mammocare';
Yii::$app->params['og_description'] = 'Tải về brochure, hướng dẫn chuẩn bị và tài liệu chuyên môn về ung thư vú';

// Define download categories and files
$downloadCategories = [
    'brochure' => [
        'title' => 'Brochure Dịch vụ',
        'description' => 'Tài liệu giới thiệu các dịch vụ tầm soát và điều trị',
        'icon' => 'fas fa-file-alt',
        'files' => [
            [
                'name' => 'Brochure Dịch vụ Mammocare 2024',
                'description' => 'Tổng quan về các dịch vụ tầm soát và điều trị ung thư vú',
                'size' => '2.5 MB',
                'type' => 'PDF'
            ],
            [
                'name' => 'Hướng dẫn Chụp X-quang tuyến vú',
                'description' => 'Thông tin chi tiết về quy trình chụp X-quang tuyến vú',
                'size' => '1.8 MB',
                'type' => 'PDF'
            ],
            [
                'name' => 'Dịch vụ Siêu âm tuyến vú',
                'description' => 'Giới thiệu về dịch vụ siêu âm tuyến vú không xâm lấn',
                'size' => '1.2 MB',
                'type' => 'PDF'
            ]
        ]
    ],
    'preparation' => [
        'title' => 'Hướng dẫn Chuẩn bị',
        'description' => 'Tài liệu hướng dẫn chuẩn bị trước khi khám',
        'icon' => 'fas fa-clipboard-list',
        'files' => [
            [
                'name' => 'Checklist Chuẩn bị Khám',
                'description' => 'Danh sách kiểm tra trước khi đến khám',
                'size' => '0.8 MB',
                'type' => 'PDF'
            ],
            [
                'name' => 'Hướng dẫn Chuẩn bị Chụp X-quang',
                'description' => 'Những điều cần biết trước khi chụp X-quang tuyến vú',
                'size' => '1.5 MB',
                'type' => 'PDF'
            ],
            [
                'name' => 'Chuẩn bị Sinh thiết',
                'description' => 'Hướng dẫn chuẩn bị trước khi làm sinh thiết',
                'size' => '1.1 MB',
                'type' => 'PDF'
            ]
        ]
    ],
    'medical' => [
        'title' => 'Tài liệu Chuyên môn',
        'description' => 'Tài liệu y khoa chuyên sâu về ung thư vú',
        'icon' => 'fas fa-stethoscope',
        'files' => [
            [
                'name' => 'Hướng dẫn Tầm soát Ung thư vú',
                'description' => 'Tài liệu chuyên môn về tầm soát ung thư vú',
                'size' => '3.2 MB',
                'type' => 'PDF'
            ],
            [
                'name' => 'Phác đồ Điều trị Ung thư vú',
                'description' => 'Các phương pháp điều trị ung thư vú hiện đại',
                'size' => '4.1 MB',
                'type' => 'PDF'
            ],
            [
                'name' => 'Nghiên cứu Ung thư vú 2024',
                'description' => 'Tổng hợp các nghiên cứu mới nhất về ung thư vú',
                'size' => '5.8 MB',
                'type' => 'PDF'
            ]
        ]
    ],
    'infographics' => [
        'title' => 'Infographics',
        'description' => 'Hình ảnh minh họa dễ hiểu về ung thư vú',
        'icon' => 'fas fa-chart-pie',
        'files' => [
            [
                'name' => 'Quy trình Tầm soát Ung thư vú',
                'description' => 'Sơ đồ minh họa quy trình tầm soát ung thư vú',
                'size' => '2.1 MB',
                'type' => 'PNG'
            ],
            [
                'name' => 'Các Giai đoạn Ung thư vú',
                'description' => 'Hình ảnh minh họa các giai đoạn phát triển ung thư vú',
                'size' => '1.9 MB',
                'type' => 'PNG'
            ],
            [
                'name' => 'Phương pháp Điều trị',
                'description' => 'Sơ đồ các phương pháp điều trị ung thư vú',
                'size' => '2.3 MB',
                'type' => 'PNG'
            ]
        ]
    ]
];
?>

<style>
.downloads-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.downloads-header {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 3rem;
}

.downloads-header h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: #289cd7;
}

.downloads-header p {
    font-size: 1.3rem;
    color: #6c757d;
    font-weight: 400;
}

.category-section {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.category-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #e9ecef;
}

.category-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 2rem;
}

.category-title {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.category-description {
    color: #6c757d;
    font-size: 1rem;
}

.file-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
}

.file-item {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.file-item:hover {
    border-color: #289cd7;
    background: #f0f8ff;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.file-header {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.file-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    margin-right: 1rem;
    flex-shrink: 0;
}

.file-info {
    flex: 1;
}

.file-name {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.file-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.4;
    margin-bottom: 0.8rem;
}

.file-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.file-size {
    background: #e3f2fd;
    color: #289cd7;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.file-type {
    background: #f8f9fa;
    color: #6c757d;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.download-btn {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    border: none;
    border-radius: 25px;
    padding: 0.8rem 1.5rem;
    color: white;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.download-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.3);
    color: white;
    text-decoration: none;
}

.search-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.search-box {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
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

@media (max-width: 768px) {
    .downloads-header h1 {
        font-size: 2.2rem;
    }
    
    .downloads-header p {
        font-size: 1.1rem;
    }
    
    .category-section, .search-section {
        padding: 1.5rem;
    }
    
    .file-list {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .file-item {
        padding: 1rem;
    }
    
    .file-header {
        flex-direction: column;
        text-align: center;
    }
    
    .file-icon {
        margin: 0 auto 1rem;
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
                <li class="breadcrumb-item active">Tài liệu Tải về</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Downloads Page -->
<section class="downloads-page py-5">
    <div class="container">
        <div class="downloads-header text-center mb-5">
            <h1 class="mb-3">Tài liệu Tải về</h1>
            <p class="text-muted">Tải về brochure, hướng dẫn chuẩn bị và tài liệu chuyên môn</p>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Tìm kiếm tài liệu..." id="file-search">
            </div>
        </div>

        <!-- Download Categories -->
        <?php foreach ($downloadCategories as $categoryKey => $category): ?>
            <div class="category-section" data-category="<?= $categoryKey ?>">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="<?= $category['icon'] ?>"></i>
                    </div>
                    <h2 class="category-title"><?= $category['title'] ?></h2>
                    <p class="category-description"><?= $category['description'] ?></p>
                </div>

                <div class="file-list">
                    <?php foreach ($category['files'] as $file): ?>
                        <div class="file-item" data-name="<?= strtolower($file['name']) ?>">
                            <div class="file-header">
                                <div class="file-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="file-info">
                                    <h4 class="file-name"><?= $file['name'] ?></h4>
                                    <p class="file-description"><?= $file['description'] ?></p>
                                </div>
                            </div>
                            <div class="file-meta">
                                <span class="file-size"><?= $file['size'] ?></span>
                                <span class="file-type"><?= $file['type'] ?></span>
                            </div>
                            <a href="#" class="download-btn" onclick="downloadFile('<?= $file['name'] ?>')">
                                <i class="fas fa-download"></i>
                                Tải về
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
// Search functionality
document.getElementById('file-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const fileItems = document.querySelectorAll('.file-item');
    
    fileItems.forEach(item => {
        const fileName = item.getAttribute('data-name');
        if (fileName.includes(searchTerm)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Hide/show category sections based on visible files
    const categorySections = document.querySelectorAll('.category-section');
    categorySections.forEach(section => {
        const visibleFiles = section.querySelectorAll('.file-item[style*="block"], .file-item:not([style*="none"])');
        if (visibleFiles.length === 0 && searchTerm !== '') {
            section.style.display = 'none';
        } else {
            section.style.display = 'block';
        }
    });
});

// Download function
function downloadFile(fileName) {
    // In real implementation, this would trigger actual file download
    // For now, we'll show a message
    alert('Tính năng tải về sẽ được kích hoạt khi có file thực tế.\n\nFile: ' + fileName);
    
    // Simulate download
    const btn = event.target.closest('.download-btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang tải...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = '<i class="fas fa-check"></i> Đã tải';
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    }, 1500);
}

// Category filter (if needed)
function filterByCategory(category) {
    const sections = document.querySelectorAll('.category-section');
    sections.forEach(section => {
        if (category === 'all' || section.getAttribute('data-category') === category) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
}
</script>
