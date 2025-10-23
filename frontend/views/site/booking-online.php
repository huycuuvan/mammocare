<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Product;
use backend\models\Supporter;
use backend\models\CatDoctor;

/* @var $this yii\web\View */
/* @var $model frontend\models\BookingForm */

$this->title = 'Đặt lịch Online - Mammocare';
Yii::$app->params['og_description'] = 'Đặt lịch khám trực tuyến tại Mammocare - Form đơn giản, nhanh chóng';
?>

<!-- Flash Messages -->
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= Yii::$app->session->getFlash('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= Yii::$app->session->getFlash('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<style>
/* Font và spacing đồng bộ với trang chủ */
.booking-form {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 2rem 0;
    font-family: inherit;
}

/* Icon spacing chuẩn */
.booking-form i {
    margin-right: 8px;
    margin-left: 8px;
}

.booking-form .me-2 {
    margin-right: 8px !important;
}

.booking-form .ms-2 {
    margin-left: 8px !important;
}

.booking-form .me-1 {
    margin-right: 4px !important;
}

.booking-form .ms-1 {
    margin-left: 4px !important;
}

.booking-header {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 3rem;
}

.booking-header h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: #289cd7;
    font-family: inherit;
    line-height: 1.2;
}

.booking-header p {
    font-size: 1.3rem;
    color: #6c757d;
    font-weight: 400;
    font-family: inherit;
    line-height: 1.5;
}

.progress-steps {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    border: 1px solid #f1f3f4;
    position: relative;
}

.progress-steps::before {
    content: '';
    position: absolute;
    top: 30px;
    left: 12.5%;
    right: 12.5%;
    height: 3px;
    background: #e9ecef;
    z-index: 1;
    border-radius: 2px;
}

.step {
    text-align: center;
    position: relative;
    z-index: 2;
}

.step-number {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f8f9fa;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.4rem;
    margin: 0 auto 1rem;
    transition: all 0.4s ease;
    border: 3px solid #e9ecef;
}

.step.active .step-number {
    background: #289cd7;
    color: white;
    border-color: #289cd7;
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(40,156,215,0.3);
}

.step.completed .step-number {
    background: #28a745;
    color: white;
    border-color: #28a745;
    box-shadow: 0 8px 25px rgba(40,167,69,0.3);
}

.step-title {
    font-weight: 600;
    color: #495057;
    font-size: 1.1rem;
}

.step.active .step-title {
    color: #289cd7;
    font-weight: 700;
}

.booking-form-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    overflow: hidden;
    border: 1px solid #f1f3f4;
}

.card-header {
    background: linear-gradient(135deg, #289cd7 0%, #1e7bb8 100%);
    border: none;
    padding: 1.5rem 2rem;
}

.card-header h5 {
    font-weight: 700;
    font-size: 1.3rem;
    margin: 0;
}

.card-body {
    padding: 2rem;
}

.form-label {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.8rem;
    font-family: inherit;
    line-height: 1.4;
}

.form-select, .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 1.2rem;
    transition: all 0.3s ease;
    font-size: 1rem;
    background: #fafbfc;
}

.form-select:focus, .form-control:focus {
    border-color: #289cd7;
    box-shadow: 0 0 0 0.2rem rgba(40,156,215,0.15);
    background: white;
}

.branch-selection .form-check {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.branch-selection .form-check:hover {
    border-color: #289cd7;
    background: #f0f8ff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40,156,215,0.15);
}

.branch-selection .form-check-input:checked + .form-check-label {
    color: #289cd7;
}

.branch-selection .form-check-input:checked ~ * {
    border-color: #289cd7;
    background: #e3f2fd;
    box-shadow: 0 8px 25px rgba(40,156,215,0.2);
}

.branch-selection .form-check-label strong {
    color: #289cd7;
    font-weight: 700;
    font-size: 1.1rem;
}

.branch-selection .form-check-label small {
    color: #6c757d;
    font-size: 0.95rem;
}

.btn-primary {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 12px;
    padding: 1rem 2.5rem;
    font-weight: 700;
    color: white;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40,167,69,0.3);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(40,167,69,0.4);
    color: white;
}

.btn-secondary {
    background: #6c757d;
    border: none;
    border-radius: 12px;
    padding: 1rem 2.5rem;
    font-weight: 700;
    color: white;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
    transform: translateY(-2px);
}

.time-slot {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1.2rem;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    background: #fafbfc;
}

.time-slot:hover {
    border-color: #289cd7;
    background: #f0f8ff;
    transform: translateY(-2px);
}

.time-slot.selected {
    border-color: #289cd7;
    background: #e3f2fd;
    box-shadow: 0 4px 15px rgba(40,156,215,0.2);
}

.time-slot input[type="radio"] {
    margin-right: 0.8rem;
    transform: scale(1.2);
}

.doctor-card {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.doctor-card:hover {
    border-color: #289cd7;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.doctor-card.selected {
    border-color: #289cd7;
    background: #e3f2fd;
    box-shadow: 0 8px 25px rgba(40,156,215,0.2);
}

.doctor-card input[type="radio"] {
    margin-right: 0.8rem;
    transform: scale(1.2);
}

.doctor-info h5 {
    color: #289cd7;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.doctor-info p {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.95rem;
}

.form-check-input:checked {
    background-color: #289cd7;
    border-color: #289cd7;
}

.form-check-input:focus {
    border-color: #289cd7;
    box-shadow: 0 0 0 0.2rem rgba(40,156,215,0.25);
}

.form-step {
    display: none;
}

.form-step.active {
    display: block;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .booking-form-container {
        margin: 0 1rem;
    }
}

@media (max-width: 992px) {
    .booking-header h1 {
        font-size: 2.4rem;
    }
    
    .booking-header p {
        font-size: 1.2rem;
    }
    
    .progress-steps {
        padding: 2rem;
    }
    
    .step-number {
        width: 55px;
        height: 55px;
        font-size: 1.3rem;
    }
    
    .card-body {
        padding: 1.8rem;
    }
}

@media (max-width: 768px) {
    .booking-form {
        padding: 1rem 0;
    }
    
    .booking-header h1 {
        font-size: 2rem;
        margin-bottom: 0.8rem;
    }
    
    .booking-header p {
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    
    .progress-steps {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .step-number {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
        margin-bottom: 0.8rem;
    }
    
    .step-title {
        font-size: 0.9rem;
    }
    
    .card-header {
        padding: 1rem 1.5rem;
    }
    
    .card-header h5 {
        font-size: 1.1rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .form-label {
        font-size: 1rem;
        margin-bottom: 0.6rem;
    }
    
    .form-select, .form-control {
        padding: 0.8rem 1rem;
        font-size: 0.95rem;
    }
    
    .branch-selection .form-check {
        padding: 1.2rem;
        margin-bottom: 0.8rem;
    }
    
    .branch-selection .form-check-label strong {
        font-size: 1rem;
    }
    
    .branch-selection .form-check-label small {
        font-size: 0.85rem;
    }
    
    .time-slot {
        padding: 1rem;
        margin-bottom: 0.8rem;
    }
    
    .doctor-card {
        padding: 1.2rem;
        margin-bottom: 0.8rem;
    }
    
    .doctor-info h5 {
        font-size: 1.1rem;
    }
    
    .doctor-info p {
        font-size: 0.9rem;
    }
    
    .btn-primary, .btn-secondary {
        padding: 0.8rem 1.5rem;
        font-size: 0.95rem;
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .d-flex.justify-content-between .btn {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .booking-form {
        padding: 0.5rem 0;
    }
    
    .container {
        padding: 0 1rem;
    }
    
    .booking-header h1 {
        font-size: 1.8rem;
        line-height: 1.3;
    }
    
    .booking-header p {
        font-size: 0.95rem;
    }
    
    .progress-steps {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        margin-bottom: 0.6rem;
    }
    
    .step-title {
        font-size: 0.8rem;
        line-height: 1.2;
    }
    
    .card-header {
        padding: 0.8rem 1rem;
    }
    
    .card-header h5 {
        font-size: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .form-label {
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }
    
    .form-select, .form-control {
        padding: 0.7rem 0.8rem;
        font-size: 0.9rem;
    }
    
    .branch-selection .form-check {
        padding: 1rem;
        margin-bottom: 0.6rem;
    }
    
    .branch-selection .form-check-label strong {
        font-size: 0.95rem;
    }
    
    .branch-selection .form-check-label small {
        font-size: 0.8rem;
    }
    
    .time-slot {
        padding: 0.8rem;
        margin-bottom: 0.6rem;
    }
    
    .doctor-card {
        padding: 1rem;
        margin-bottom: 0.6rem;
    }
    
    .doctor-info h5 {
        font-size: 1rem;
    }
    
    .doctor-info p {
        font-size: 0.85rem;
    }
    
    .btn-primary, .btn-secondary {
        padding: 0.7rem 1.2rem;
        font-size: 0.9rem;
    }
    
    .text-end {
        text-align: center !important;
    }
    
    .modal-dialog {
        margin: 0.5rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .booking-summary .row {
        margin: 0;
    }
    
    .booking-summary .col-md-6 {
        padding: 0.5rem;
    }
}

@media (max-width: 480px) {
    .booking-header h1 {
        font-size: 1.6rem;
    }
    
    .step-number {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
    
    .step-title {
        font-size: 0.75rem;
    }
    
    .card-body {
        padding: 0.8rem;
    }
    
    .form-select, .form-control {
        padding: 0.6rem 0.7rem;
        font-size: 0.85rem;
    }
    
    .btn-primary, .btn-secondary {
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }
}
</style>

<?php
// Lấy data từ database
$services = Product::find()
    ->where(['active' => 1])
    ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
    ->limit(10)
    ->all();

// Nếu không có data từ Product, tạo data mẫu
if (empty($services)) {
    $services = [];
    
    // Tạo data mẫu
    $sampleServices = [
        ['id' => 1, 'name' => 'Chụp X-quang tuyến vú 2D', 'brief' => 'Kỹ thuật chụp X-quang 2D chuẩn'],
        ['id' => 2, 'name' => 'Chụp X-quang tuyến vú 3D', 'brief' => 'Kỹ thuật chụp X-quang 3D tiên tiến'],
        ['id' => 3, 'name' => 'Siêu âm tuyến vú', 'brief' => 'Siêu âm tuyến vú không xâm lấn'],
        ['id' => 4, 'name' => 'Sinh thiết tuyến vú', 'brief' => 'Sinh thiết lấy mẫu mô để xét nghiệm'],
        ['id' => 5, 'name' => 'Tư vấn chuyên khoa', 'brief' => 'Tư vấn với bác sĩ chuyên khoa']
    ];
    
    foreach($sampleServices as $data) {
        $service = new \stdClass();
        $service->id = $data['id'];
        $service->name = $data['name'];
        $service->brief = $data['brief'];
        $services[] = $service;
    }
}

$doctors = Supporter::getAllSupport();
$specialties = CatDoctor::getParent();
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= Url::home() ?>">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?= Url::to(['site/booking']) ?>">Đặt lịch khám</a></li>
                <li class="breadcrumb-item active">Đặt lịch Online</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Booking Form -->
<section class="booking-form py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="booking-header text-center mb-5">
                    <h1 class="mb-3">Đặt lịch Online</h1>
                    <p class="text-muted">Điền thông tin để đặt lịch khám nhanh chóng và tiện lợi</p>
                </div>

                <!-- Progress Steps -->
                <div class="progress-steps mb-5">
                    <div class="row">
                        <div class="col-4">
                            <div class="step active" id="step1">
                                <div class="step-number">1</div>
                                <div class="step-title">Chọn dịch vụ</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="step" id="step2">
                                <div class="step-number">2</div>
                                <div class="step-title">Chọn bác sĩ & giờ</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="step" id="step3">
                                <div class="step-number">3</div>
                                <div class="step-title">Thông tin cá nhân</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Container -->
                <div class="booking-form-container">
                    <?php $form = ActiveForm::begin([
                        'id' => 'booking-form',
                        'options' => ['class' => 'needs-validation', 'novalidate' => true]
                    ]); ?>

                    <!-- Step 1: Service & Branch Selection -->
                    <div class="form-step active" id="form-step-1">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Bước 1: Chọn dịch vụ & Chi nhánh</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Dịch vụ khám *</label>
                                        <?= $form->field($model, 'service_id')->dropDownList(
                                            \yii\helpers\ArrayHelper::map($services, 'id', 'name'),
                                            ['prompt' => '-- Chọn dịch vụ --', 'class' => 'form-select']
                                        )->label(false) ?>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Chi nhánh *</label>
                                        <div class="branch-selection">
                                            <?= $form->field($model, 'branch')->radioList([
                                                'hanoi' => '<strong>Hà Nội</strong><br><small class="text-muted">243 Đường Giải Phóng, Phường Phương Mai, Quận Đống Đa</small>',
                                                'nghean' => '<strong>Nghệ An</strong><br><small class="text-muted">Tầng 2, BV Ngoại khoa 115 Nghệ An, số 40 - Đại lộ Xô Viết Nghệ Tĩnh - TP Vinh</small>'
                                            ], [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $id = 'branch-' . $value;
                                                    return '<div class="form-check">' .
                                                        Html::radio($name, $checked, ['value' => $value, 'id' => $id, 'class' => 'form-check-input']) .
                                                        '<label class="form-check-label" for="' . $id . '">' . $label . '</label>' .
                                                        '</div>';
                                                }
                                            ])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-primary btn-lg" onclick="nextStep(2)">
                                        Tiếp tục <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Doctor & Time Selection -->
                    <div class="form-step" id="form-step-2">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-user-md me-2"></i>Bước 2: Chọn bác sĩ & Giờ khám</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Ngày khám *</label>
                                        <?= $form->field($model, 'preferred_date')->input('date', ['class' => 'form-control'])->label(false) ?>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Giờ khám *</label>
                                        <div class="time-slots">
                                            <?= $form->field($model, 'preferred_time')->radioList([
                                                '8:00' => '8:00',
                                                '9:00' => '9:00', 
                                                '10:00' => '10:00',
                                                '14:00' => '14:00',
                                                '15:00' => '15:00',
                                                '16:00' => '16:00'
                                            ], [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $id = 'time-' . str_replace(':', '', $value);
                                                    return '<div class="time-slot">' .
                                                        Html::radio($name, $checked, ['value' => $value, 'id' => $id]) .
                                                        '<label for="' . $id . '">' . $label . '</label>' .
                                                        '</div>';
                                                }
                                            ])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <label class="form-label fw-bold">Chọn bác sĩ (tùy chọn)</label>
                                        <div class="doctor-selection">
                                            <?php 
                                            $doctorOptions = ['' => 'Sẽ được sắp xếp - Bác sĩ phù hợp sẽ được phân công'];
                                            if (!empty($doctors)) {
                                                foreach ($doctors as $doctor) {
                                                    $doctorOptions[$doctor->id] = $doctor->name . ' - ' . ($doctor->father ? $doctor->father->name : 'Chuyên khoa');
                                                }
                                            }
                                            ?>
                                            <?= $form->field($model, 'doctor_id')->radioList($doctorOptions, [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $id = $value ? 'doctor-' . $value : 'doctor-auto';
                                                    return '<div class="doctor-card">' .
                                                        Html::radio($name, $checked, ['value' => $value, 'id' => $id]) .
                                                        '<label for="' . $id . '">' .
                                                        '<div class="doctor-info">' .
                                                        '<h5>' . ($value ? explode(' - ', $label)[0] : 'Sẽ được sắp xếp') . '</h5>' .
                                                        '<p>' . ($value ? explode(' - ', $label)[1] : 'Bác sĩ phù hợp sẽ được phân công') . '</p>' .
                                                        '</div>' .
                                                        '</label>' .
                                                        '</div>';
                                                }
                                            ])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                        Tiếp tục <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Personal Information -->
                    <div class="form-step" id="form-step-3">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Bước 3: Thông tin cá nhân</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Họ và tên *</label>
                                        <?= $form->field($model, 'name')->textInput(['class' => 'form-control'])->label(false) ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Số điện thoại *</label>
                                        <?= $form->field($model, 'phone')->textInput(['type' => 'tel', 'class' => 'form-control'])->label(false) ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Email</label>
                                        <?= $form->field($model, 'email')->textInput(['type' => 'email', 'class' => 'form-control'])->label(false) ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Tuổi</label>
                                        <input type="number" class="form-control" name="age" min="1" max="120">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Ghi chú (tùy chọn)</label>
                                        <?= $form->field($model, 'message')->textarea(['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Mô tả tình trạng sức khỏe, triệu chứng hoặc yêu cầu đặc biệt...'])->label(false) ?>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-calendar-check me-2"></i>Đặt lịch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Đặt lịch thành công!</h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-calendar-check fa-4x text-success mb-3"></i>
                    <h4 class="text-success">Đặt lịch thành công!</h4>
                </div>
                <div class="booking-summary">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã đặt lịch:</strong> <span class="text-primary" id="booking-code">#MC123456</span></p>
                            <p><strong>Dịch vụ:</strong> <span id="booking-service">Chụp X-quang 3D</span></p>
                            <p><strong>Ngày giờ:</strong> <span id="booking-datetime">20/10/2025 - 9:00</span></p>
                            <p><strong>Chi nhánh:</strong> <span id="booking-branch">Hà Nội</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Bác sĩ:</strong> <span id="booking-doctor">BS. Nguyễn Văn A</span></p>
                            <p><strong>Họ tên:</strong> <span id="booking-name">Nguyễn Thị B</span></p>
                            <p><strong>SĐT:</strong> <span id="booking-phone">0912345678</span></p>
                            <p><strong>Email:</strong> <span id="booking-email">example@email.com</span></p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Thông tin xác nhận</h6>
                    <p class="mb-0">Chúng tôi đã gửi xác nhận qua SMS và Email. Vui lòng kiểm tra và giữ lại thông tin đặt lịch.</p>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Thời gian xác nhận: <span id="booking-confirm-time"></span><br>
                            <i class="fas fa-map-marker-alt me-1"></i>Địa chỉ: <span id="booking-address"></span>
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" onclick="printBooking()">
                    <i class="fas fa-print me-2"></i>In phiếu khám
                </button>
                <a href="<?= Url::home() ?>" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Về trang chủ
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let currentStep = 1;

function nextStep(step) {
    if (validateCurrentStep()) {
        // Hide current step
        document.getElementById('form-step-' + currentStep).style.display = 'none';
        document.getElementById('step' + currentStep).classList.remove('active');
        document.getElementById('step' + currentStep).classList.add('completed');
        
        // Show next step
        currentStep = step;
        document.getElementById('form-step-' + currentStep).style.display = 'block';
        document.getElementById('step' + currentStep).classList.add('active');
        
        // Scroll to top of form
        document.querySelector('.booking-form-container').scrollIntoView({ behavior: 'smooth' });
    }
}

function prevStep(step) {
    // Hide current step
    document.getElementById('form-step-' + currentStep).style.display = 'none';
    document.getElementById('step' + currentStep).classList.remove('active');
    
    // Show previous step
    currentStep = step;
    document.getElementById('form-step-' + currentStep).style.display = 'block';
    document.getElementById('step' + currentStep).classList.add('active');
    document.getElementById('step' + currentStep).classList.remove('completed');
    
    // Scroll to top of form
    document.querySelector('.booking-form-container').scrollIntoView({ behavior: 'smooth' });
}

function validateCurrentStep() {
    if (currentStep === 1) {
        const service = document.querySelector('select[name="BookingForm[service_id]"]');
        const branch = document.querySelector('input[name="BookingForm[branch]"]:checked');
        
        if (!service || !service.value) {
            alert('Vui lòng chọn dịch vụ khám');
            return false;
        }
        if (!branch) {
            alert('Vui lòng chọn chi nhánh');
            return false;
        }
    } else if (currentStep === 2) {
        const doctor = document.querySelector('input[name="BookingForm[doctor_id]"]:checked');
        const timeSlot = document.querySelector('input[name="BookingForm[preferred_time]"]:checked');
        const appointmentDate = document.querySelector('input[name="BookingForm[preferred_date]"]');
        
        if (!appointmentDate || !appointmentDate.value) {
            alert('Vui lòng chọn ngày khám');
            return false;
        }
        if (!timeSlot) {
            alert('Vui lòng chọn giờ khám');
            return false;
        }
    } else if (currentStep === 3) {
        const fullName = document.querySelector('input[name="BookingForm[name]"]');
        const phone = document.querySelector('input[name="BookingForm[phone]"]');
        const email = document.querySelector('input[name="BookingForm[email]"]');
        
        if (!fullName || !fullName.value) {
            alert('Vui lòng nhập họ và tên');
            return false;
        }
        if (!phone || !phone.value) {
            alert('Vui lòng nhập số điện thoại');
            return false;
        }
        if (!email || !email.value) {
            alert('Vui lòng nhập email');
            return false;
        }
    }
    return true;
}

// Add interactive effects for radio buttons
document.addEventListener('DOMContentLoaded', function() {
    // Branch selection effects
    const branchRadios = document.querySelectorAll('input[name="BookingForm[branch]"]');
    branchRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected class from all branch options
            document.querySelectorAll('.branch-selection .form-check').forEach(option => {
                option.classList.remove('selected');
            });
            
            // Add selected class to current option
            if (this.checked) {
                this.closest('.form-check').classList.add('selected');
            }
        });
    });
    
    // Doctor selection effects
    const doctorRadios = document.querySelectorAll('input[name="doctor"]');
    doctorRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected class from all doctor cards
            document.querySelectorAll('.doctor-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to current card
            if (this.checked) {
                this.closest('.doctor-card').classList.add('selected');
            }
        });
    });
    
    // Time slot selection effects
    const timeRadios = document.querySelectorAll('input[name="time_slot"]');
    timeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove selected class from all time slots
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });
            
            // Add selected class to current slot
            if (this.checked) {
                this.closest('.time-slot').classList.add('selected');
            }
        });
    });
    
    // Form submission - Let form submit normally to server
    document.getElementById('booking-form').addEventListener('submit', function(e) {
        // Only prevent default if validation fails
        if (!validateCurrentStep()) {
            e.preventDefault();
        }
        // If validation passes, let form submit to server
    });
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.querySelector('input[name="BookingForm[preferred_date]"]');
    if (dateInput) {
        dateInput.setAttribute('min', today);
    }
});

function populateSuccessModal() {
    // Get form data
    const serviceSelect = document.querySelector('select[name="BookingForm[service_id]"]');
    const serviceId = serviceSelect ? serviceSelect.value : '';
    const serviceName = serviceSelect && serviceSelect.selectedOptions[0] ? serviceSelect.selectedOptions[0].text : '';
    const branchRadio = document.querySelector('input[name="BookingForm[branch]"]:checked');
    const branch = branchRadio ? branchRadio.value : '';
    const branchName = branchRadio ? branchRadio.nextElementSibling.querySelector('strong').textContent : '';
    const doctorRadio = document.querySelector('input[name="BookingForm[doctor_id]"]:checked');
    const doctorId = doctorRadio ? doctorRadio.value : '';
    const doctorName = doctorRadio ? doctorRadio.nextElementSibling.querySelector('h5').textContent : 'Sẽ được sắp xếp';
    const appointmentDateInput = document.querySelector('input[name="BookingForm[preferred_date]"]');
    const appointmentDate = appointmentDateInput ? appointmentDateInput.value : '';
    const timeSlotRadio = document.querySelector('input[name="BookingForm[preferred_time]"]:checked');
    const timeSlot = timeSlotRadio ? timeSlotRadio.value : '';
    const fullNameInput = document.querySelector('input[name="BookingForm[name]"]');
    const fullName = fullNameInput ? fullNameInput.value : '';
    const phoneInput = document.querySelector('input[name="BookingForm[phone]"]');
    const phone = phoneInput ? phoneInput.value : '';
    const emailInput = document.querySelector('input[name="BookingForm[email]"]');
    const email = emailInput ? emailInput.value : '';
    const notesInput = document.querySelector('textarea[name="BookingForm[message]"]');
    const notes = notesInput ? notesInput.value : '';
    
    // Generate booking code
    const bookingCode = '#MC' + Math.random().toString(36).substr(2, 6).toUpperCase();
    
    // Format date
    const dateObj = new Date(appointmentDate);
    const formattedDate = dateObj.toLocaleDateString('vi-VN');
    const formattedTime = timeSlot + ':00';
    
    // Get branch address
    const branchAddress = branch === 'hanoi' 
        ? '243 Đường Giải Phóng, Phường Phương Mai, Quận Đống Đa, Hà Nội'
        : 'Tầng 2, BV Ngoại khoa 115 Nghệ An, số 40 - Đại lộ Xô Viết Nghệ Tĩnh - TP Vinh';
    
    // Get current time
    const now = new Date();
    const confirmTime = now.toLocaleString('vi-VN');
    
    // Update modal content
    document.getElementById('booking-code').textContent = bookingCode;
    document.getElementById('booking-service').textContent = serviceName;
    document.getElementById('booking-datetime').textContent = formattedDate + ' - ' + formattedTime;
    document.getElementById('booking-branch').textContent = branchName;
    document.getElementById('booking-doctor').textContent = doctorName;
    document.getElementById('booking-name').textContent = fullName;
    document.getElementById('booking-phone').textContent = phone;
    document.getElementById('booking-email').textContent = email;
    document.getElementById('booking-confirm-time').textContent = confirmTime;
    document.getElementById('booking-address').textContent = branchAddress;
}

function printBooking() {
    window.print();
}
</script>
