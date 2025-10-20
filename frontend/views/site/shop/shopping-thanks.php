<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
use backend\models\Page;
use backend\models\Seo;
use backend\models\Province;
use backend\models\District;
use backend\models\Ward;
use backend\models\Buyer;
use backend\models\Contact;
use yii\bootstrap\ActiveForm;

$seo = Seo::getSeo(Seo::THANK_PAGE);
if(!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = 'Đặt hàng thành công';
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shopping-checkout'), 'url' => ['site/shopping-order']];
$cart = \Yii::$app->cart;
$model=Buyer::findOne($order_id);
?>
<section class="content shopping py-4 bg_grey">
    <div class="container">
        <?php
        if(!empty($this->params['big-title'])){
            if(!empty($this->params['big-header']) )
                echo '<h1 class="header-title mb-3 pb-2">'.$this->params['big-title'].'</h1>';
            else
                echo '<div class="header-title mb-3 pb-2">'.$this->params['big-title'].'</div>';
        }
        if(!empty($model)) {
            $record_type=$model->type_id==1?'Thanh toán khi giao hàng':'Chuyển khoản qua ngân hàng';
            ?>
            <div class="mt-4 bg_white shopping-thanks p-4">
                <div class="text-center mb-3">
                    <img src="upload/success-icon.svg" alt="Đặt hàng thành công"/>
                </div>
                <p class="title text-center text-uppercase font-weight-bold">Đặt hàng thành công</p>
                <div class="thanks-message">
                    <p>Cảm ơn <strong>Anh/Chị <?=$model->fullname?></strong>  đã mua hàng.</p>
                    <p>Chúng tôi sẽ liên hệ với anh/chị để xác nhận đơn hàng.</p>
                </div>
                <div class="thanks-detail">
                    <p class="title text-uppercase font-weight-bold">Thông tin đơn hàng</p>

                    <div class="col-md-12 bg_grey py-4">
                        <p> - Người nhận: <strong>Anh/Chị <?=$model->fullname?></strong></p>
                        <p> - Điện thoại: <strong><?=$model->mobile?></strong></p>
                        <p> - Email: <strong><?=$model->email?></strong></p>
                        <p> - Địa chỉ nhận hàng: <strong><?=$model->address?></strong></p>
                        <p> - Hình thức thanh toán : <strong><?=$record_type?></strong></p>
                        <p class="mb-0"> - Tổng tiền: <strong><?=$model->total_price?></strong></p>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>