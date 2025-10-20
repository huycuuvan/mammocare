<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Cập nhật';
$this->params['breadcrumbs'][] = ['label' => 'Liên hệ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm chi nhánh', ['create'], ['class' => 'btn btn-primary rounded-sm', 'id' => 'new_office']);
?>
<div class="contact-office">
    <div class="row row-wrapper" id="office_wrapper">

        
        <div class="col-md-4 item" data-key="head">
            <div class="white_bg">
                <div class="container-fluid">
                    <h3>Thông tin liên hệ trụ sở</h3>
                    <div class="wrapper_i">
                        <p>Đỉa chỉ: <?=$model->address; ?></p>
                        <p>Điện thoại: <?=$model->phone; ?></p>
                        <p>Hotline: <?=$model->hotline; ?></p>
                        <p>Email: <?=$model->email; ?></p>
                        <p>Vị trí: <?=$model->map; ?></p>
                        <?php $f = json_encode([
                            "name" => $model->head_office,
                            "address" => $model->address,
                            "phone" => $model->phone,
                            "hotline" => $model->hotline,
                            "email" => $model->email,
                            "map" => $model->map
                        ]); ?>
                        <input type="hidden" name="init" value='<?= $f ?>' />
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-5"></div>
                        <div class="col-7 text-right">
                            <button type="button" name="edit" class="btn btn-secondary rounded-sm"><i class="far fa-edit"></i> Chỉnh sửa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row" id="list_office">
                <input type="hidden" name="init" value='<?=$model->json_office; ?>' />
            </div>
        </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="officeForm" tabindex="-1" role="dialog" aria-labelledby="officeFormTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="officeFormTitle">Cập nhật chi nhánh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-group" action="" method="post">
                    <div class="row">
                        <div class="col-12">
                            <input type="text" class="form-control" name="name" placeholder="Tên chi nhánh" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="text" class="form-control" name="address" placeholder="Địa chỉ" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control" name="phone" placeholder="Điện thoại" value="">
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="hotline" placeholder="Hotline" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="text" class="form-control" name="email" placeholder="Email" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="text" class="form-control" name="map" placeholder="Vị trí bản đồ" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" name="save" class="btn btn-primary">Lưu Lại</button>
            </div>
        </div>
    </div>
</div>
