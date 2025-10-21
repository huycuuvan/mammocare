<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Hỏi đáp - Kiến thức Y khoa - Mammocare';
Yii::$app->params['og_description'] = 'Giải đáp thắc mắc về tầm soát, điều trị và phòng ngừa ung thư vú';

// Get category from URL parameter
$category = Yii::$app->request->get('category', 'mang-thai-ung-thu-vu');

// Define Q&A data
$qaData = [
    'mang-thai-ung-thu-vu' => [
        'title' => 'Về Mang thai & Ung thư vú',
        'description' => 'Giải đáp thắc mắc về việc mang thai và ung thư vú',
        'questions' => [
            [
                'question' => 'Đang mang thai có chụp X-quang được không?',
                'answer' => 'Trong thời gian mang thai, việc chụp X-quang cần được cân nhắc kỹ lưỡng. Tuy nhiên, chụp X-quang tuyến vú với liều bức xạ thấp và có biện pháp bảo vệ thai nhi vẫn có thể được thực hiện khi thực sự cần thiết. Bác sĩ sẽ đánh giá lợi ích và rủi ro trước khi chỉ định.'
            ],
            [
                'question' => 'Tôi có thể sinh con sau khi bị ung thư vú không?',
                'answer' => 'Có thể sinh con sau điều trị ung thư vú, nhưng cần thời gian để cơ thể phục hồi hoàn toàn. Thường khuyến nghị chờ ít nhất 2-3 năm sau khi hoàn thành điều trị và không có dấu hiệu tái phát. Nên thảo luận với bác sĩ về kế hoạch sinh con.'
            ],
            [
                'question' => 'Liệu việc mang thai hay cho con bú có tạo ung thư tái phát không?',
                'answer' => 'Nghiên cứu cho thấy mang thai và cho con bú không làm tăng nguy cơ tái phát ung thư vú. Thực tế, một số nghiên cứu còn cho thấy có thể có tác dụng bảo vệ. Tuy nhiên, cần theo dõi chặt chẽ trong suốt quá trình.'
            ],
            [
                'question' => 'Điều trị ung thư vú có ảnh hưởng đến thai nhi không?',
                'answer' => 'Một số phương pháp điều trị có thể ảnh hưởng đến thai nhi, đặc biệt trong 3 tháng đầu thai kỳ. Hóa trị thường được trì hoãn đến sau 3 tháng đầu. Phẫu thuật và xạ trị có thể được thực hiện với biện pháp bảo vệ thai nhi.'
            ]
        ]
    ],
    'tam-soat' => [
        'title' => 'Về Tầm soát',
        'description' => 'Thông tin về tầm soát ung thư vú',
        'questions' => [
            [
                'question' => 'Khi nào nên bắt đầu tầm soát?',
                'answer' => 'Phụ nữ từ 40 tuổi nên bắt đầu tầm soát định kỳ bằng chụp X-quang tuyến vú. Nếu có tiền sử gia đình mắc ung thư vú, nên bắt đầu sớm hơn từ 30-35 tuổi. Tự khám vú nên bắt đầu từ tuổi dậy thì.'
            ],
            [
                'question' => 'Tần suất tầm soát bao lâu một lần?',
                'answer' => 'Chụp X-quang tuyến vú nên thực hiện hàng năm từ 40 tuổi. Phụ nữ có nguy cơ cao có thể cần tầm soát 6 tháng/lần. Tự khám vú nên thực hiện hàng tháng, tốt nhất là sau khi hết kinh 3-5 ngày.'
            ],
            [
                'question' => 'Phương pháp tầm soát nào tốt nhất?',
                'answer' => 'Chụp X-quang tuyến vú là phương pháp tầm soát chuẩn vàng. Siêu âm bổ sung cho phụ nữ có mô vú đặc. MRI được khuyến nghị cho nhóm nguy cơ cao. Tự khám vú là phương pháp bổ sung quan trọng.'
            ]
        ]
    ],
    'dieu-tri' => [
        'title' => 'Về Điều trị',
        'description' => 'Thông tin về các phương pháp điều trị ung thư vú',
        'questions' => [
            [
                'question' => 'Các phương pháp điều trị ung thư vú',
                'answer' => 'Điều trị ung thư vú bao gồm: Phẫu thuật (cắt bỏ khối u hoặc toàn bộ vú), Hóa trị (tiêu diệt tế bào ung thư), Xạ trị (tiêu diệt tế bào ung thư còn sót lại), Liệu pháp hormone (ngăn chặn hormone kích thích ung thư), Liệu pháp nhắm đích (tấn công đặc hiệu tế bào ung thư).'
            ],
            [
                'question' => 'Tỷ lệ thành công',
                'answer' => 'Tỷ lệ sống sót 5 năm cho ung thư vú giai đoạn sớm (0-1) là 99-100%. Giai đoạn 2: 93%, Giai đoạn 3: 72%, Giai đoạn 4: 22%. Phát hiện sớm là yếu tố quan trọng nhất quyết định tiên lượng.'
            ],
            [
                'question' => 'Chi phí điều trị',
                'answer' => 'Chi phí điều trị ung thư vú phụ thuộc vào giai đoạn và phương pháp điều trị. Tại Việt Nam, chi phí dao động từ 50-200 triệu VNĐ cho một đợt điều trị hoàn chỉnh. Bảo hiểm y tế có thể chi trả một phần.'
            ]
        ]
    ],
    'phong-ngua' => [
        'title' => 'Về Phòng ngừa',
        'description' => 'Cách phòng ngừa ung thư vú',
        'questions' => [
            [
                'question' => 'Cách phòng ngừa ung thư vú',
                'answer' => 'Duy trì cân nặng hợp lý, tập thể dục thường xuyên, hạn chế rượu bia, không hút thuốc, cho con bú nếu có thể, tránh tiếp xúc với hormone estrogen không cần thiết, tầm soát định kỳ.'
            ],
            [
                'question' => 'Chế độ ăn uống',
                'answer' => 'Ăn nhiều rau xanh, trái cây, ngũ cốc nguyên hạt. Hạn chế thịt đỏ, thực phẩm chế biến sẵn. Bổ sung omega-3 từ cá, hạt. Hạn chế đường và chất béo bão hòa. Uống đủ nước và tránh đồ uống có cồn.'
            ],
            [
                'question' => 'Lối sống lành mạnh',
                'answer' => 'Tập thể dục ít nhất 150 phút/tuần, ngủ đủ 7-8 giờ/đêm, quản lý stress, tránh tiếp xúc với hóa chất độc hại, không hút thuốc, hạn chế rượu bia, duy trì cân nặng BMI 18.5-24.9.'
            ]
        ]
    ]
];

$currentData = $qaData[$category] ?? $qaData['mang-thai-ung-thu-vu'];
?>

<style>
.qa-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
}

.qa-header {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 3rem;
}

.qa-header h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: #289cd7;
}

.qa-header p {
    font-size: 1.3rem;
    color: #6c757d;
    font-weight: 400;
}

.category-tabs {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.tab-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.tab-link {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 25px;
    padding: 1rem 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: #6c757d;
    font-weight: 600;
    text-align: center;
    min-width: 200px;
}

.tab-link:hover, .tab-link.active {
    background: #289cd7;
    border-color: #289cd7;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.qa-content {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
}

.content-header {
    text-align: center;
    margin-bottom: 3rem;
}

.content-title {
    color: #289cd7;
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 1rem;
}

.content-description {
    color: #6c757d;
    font-size: 1.1rem;
    line-height: 1.6;
}

.qa-list {
    max-width: 800px;
    margin: 0 auto;
}

.qa-item {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.qa-item:hover {
    border-color: #289cd7;
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.qa-question {
    background: #f8f9fa;
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.qa-question:hover {
    background: #e3f2fd;
}

.qa-question h4 {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.1rem;
    margin: 0;
    flex: 1;
}

.qa-toggle {
    color: #289cd7;
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.qa-item.active .qa-toggle {
    transform: rotate(180deg);
}

.qa-answer {
    padding: 0 1.5rem;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.qa-item.active .qa-answer {
    padding: 1.5rem;
    max-height: 500px;
}

.qa-answer p {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 768px) {
    .qa-header h1 {
        font-size: 2.2rem;
    }
    
    .qa-header p {
        font-size: 1.1rem;
    }
    
    .category-tabs, .qa-content {
        padding: 1.5rem;
    }
    
    .tab-nav {
        flex-direction: column;
        align-items: center;
    }
    
    .tab-link {
        min-width: auto;
        width: 100%;
        max-width: 300px;
    }
    
    .content-title {
        font-size: 1.6rem;
    }
    
    .qa-question {
        padding: 1rem;
    }
    
    .qa-question h4 {
        font-size: 1rem;
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
                <li class="breadcrumb-item active">Hỏi đáp</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Q&A Page -->
<section class="qa-page py-5">
    <div class="container">
        <div class="qa-header text-center mb-5">
            <h1 class="mb-3">Hỏi đáp</h1>
            <p class="text-muted">Giải đáp thắc mắc về tầm soát, điều trị và phòng ngừa ung thư vú</p>
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <div class="tab-nav">
                <a href="<?= Url::to(['site/knowledge-qa', 'category' => 'mang-thai-ung-thu-vu']) ?>" 
                   class="tab-link <?= $category === 'mang-thai-ung-thu-vu' ? 'active' : '' ?>">
                    <i class="fas fa-baby me-2"></i>Mang thai & Ung thư vú
                </a>
                <a href="<?= Url::to(['site/knowledge-qa', 'category' => 'tam-soat']) ?>" 
                   class="tab-link <?= $category === 'tam-soat' ? 'active' : '' ?>">
                    <i class="fas fa-search me-2"></i>Tầm soát
                </a>
                <a href="<?= Url::to(['site/knowledge-qa', 'category' => 'dieu-tri']) ?>" 
                   class="tab-link <?= $category === 'dieu-tri' ? 'active' : '' ?>">
                    <i class="fas fa-stethoscope me-2"></i>Điều trị
                </a>
                <a href="<?= Url::to(['site/knowledge-qa', 'category' => 'phong-ngua']) ?>" 
                   class="tab-link <?= $category === 'phong-ngua' ? 'active' : '' ?>">
                    <i class="fas fa-shield-alt me-2"></i>Phòng ngừa
                </a>
            </div>
        </div>

        <!-- Q&A Content -->
        <div class="qa-content">
            <div class="content-header">
                <h2 class="content-title"><?= $currentData['title'] ?></h2>
                <p class="content-description"><?= $currentData['description'] ?></p>
            </div>

            <div class="qa-list">
                <?php foreach ($currentData['questions'] as $index => $qa): ?>
                    <div class="qa-item" data-index="<?= $index ?>">
                        <div class="qa-question" onclick="toggleQA(<?= $index ?>)">
                            <h4><?= $qa['question'] ?></h4>
                            <i class="fas fa-chevron-down qa-toggle"></i>
                        </div>
                        <div class="qa-answer">
                            <p><?= $qa['answer'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script>
function toggleQA(index) {
    const qaItem = document.querySelector(`[data-index="${index}"]`);
    const isActive = qaItem.classList.contains('active');
    
    // Close all other Q&A items
    document.querySelectorAll('.qa-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Toggle current item
    if (!isActive) {
        qaItem.classList.add('active');
    }
}

// Auto-open first Q&A item
document.addEventListener('DOMContentLoaded', function() {
    const firstQA = document.querySelector('.qa-item[data-index="0"]');
    if (firstQA) {
        firstQA.classList.add('active');
    }
});
</script>
