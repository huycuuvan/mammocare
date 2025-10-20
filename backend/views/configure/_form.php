<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\MyExt;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="configure-form">
    <div class="row row-wrapper">
        <div class="col-md-8">

            <div class="white_bg">
                <div class="container-fluid">

                    <h2 class="tab_sperate">Cấu hình số lượng</h2>

                    <div class="row">
                        <div class="col-6 col-md-3"><?= $form->field($model, 'news_per_page')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'home_news_num')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'latest_news_num')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'hot_news_num')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-md-3"><?= $form->field($model, 'prod_per_page')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'home_prod_num')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'hot_prod_num')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'orther_prod_num')->textInput(['maxlength' => true]) ?></div>
                    </div>

         

                    <h2 class="tab_sperate">Kích thước ảnh tối đa</h2>

                    <div class="row">
                        <div class="col-6 col-md-3"><?= $form->field($model, 'max_width')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'max_height')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <h2 class="tab_sperate">Kích thước thumbnail sản phẩm</h2>

                    <div class="row">
                        <div class="col-6 col-md-3"><?= $form->field($model, 'product_thumb_width')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'product_thumb_height')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <h2 class="tab_sperate">Kích thước thumbnail các mục khác (Tin tức, quảng cáo,...)</h2>

                    <div class="row">
                        <div class="col-6 col-md-3"><?= $form->field($model, 'all_thumb_width')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-6 col-md-3"><?= $form->field($model, 'all_thumb_height')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <h2 class="tab_sperate">Widget trên trang</h2>

                    <div class="row line">
                      <div class="col-6 col-md-4">
                          <?= $form->field($model, 'phone_widget')->checkBox() ?>
                      </div>
                    
                      <div class="col-6 col-md-4">
                          <?= $form->field($model, 'hotline_widget')->checkBox() ?>
                      </div>

                      <?php if (1 == Yii::$app->session->get('roles_id')): ?>
                      <div class="col-6 col-md-4">
                          <?= $form->field($model, 'editorbuilder')->checkBox() ?>
                      </div>
                      <?php endif; ?>

                      <div class="col-12">
                          <?= $form->field($model, 'color_widget')->textInput() ?>
                      </div>
                    </div>


                    <h2 class="tab_sperate">Cấu hình mạng xã hội</h2>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'facebook_url')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'wechat_url')->textInput(['maxlength' => true]) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'twitter_url')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'youtube_url')->textInput(['maxlength' => true]) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'zalo_url')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'viber_url')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'tiktok_url')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'weixin_url')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'instagram_url')->textInput(['maxlength' => true]) ?></div>
                    </div>

                    <h2 class="tab_sperate">Cấu hình thông tin khác</h2>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'head_tag')->textarea(['rows' => 8]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'closed_head_tag')->textarea(['rows' => 8]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'body_tag')->textarea(['rows' => 8]) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'closed_body_tag')->textarea(['rows' => 8]) ?></div>
                    </div>
                    

                    <h2 class="tab_sperate">Cấu hình robots.txt</h2>

                    <div class="row">
                        <div class="col-12"><?= $form->field($model, 'robots_text')->textarea(['rows' => 6]) ?></div>
                    </div>

                    <h2 class="tab_sperate">Cấu hình sitemap.xml</h2>

                    <div class="row">
                        <div class="col-12">
                            Xem nội dung sitemap.xml: <a href="<?=MyExt::getDomain().Yii::$app->urlManagerFrontend->baseUrl.'/sitemap.xml'?>" target="_blank">Sitemap.xml</a>
                        </div>
                        <div class="col-12">
                            Làm mới nội dung sitemap.xml: <a href="<?=Url::to(['configure/sitemap']); ?>">Làm mới</a>
                        </div>
                    </div>

                    <h2 class="tab_sperate">Cấu hình gửi mail</h2>

                    <div class="row">
                        <div class="col-4"><?= $form->field($model, 'sender_label')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-4"><?= $form->field($model, 'email_label')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-4"><?= $form->field($model, 'send_by_gmail')
                        ->dropDownList(
                            [1 => 'Mặc định của website', 2 => 'Gửi bằng tài khoản Gmail'],
                            ['onchange' => '
                                var chosen_val = $(this).val();
                                if (chosen_val == 1) {
                                    $("#send_by_default").show();
                                    $("#send_by_gmail").hide();
                                }

                                if (chosen_val == 2) {
                                    $("#send_by_default").hide();
                                    $("#send_by_gmail").show();
                                }
                            ']
                        ); ?></div>
                    </div>
                    <hr>
                    <div class="row"<?=($model->send_by_gmail == 2) ? ' style="display:none;"':''; ?> id="send_by_default">
                        <div class="col-6"><?= $form->field($model, 'mailgun_key')->textInput(['maxlength' => true, 'readonly' => true]) ?></div>
                        <div class="col-6"><?= $form->field($model, 'mailgun_domain')->textInput(['maxlength' => true, 'readonly' => true]) ?></div>
                    </div>
                    <div class="row"<?=($model->send_by_gmail == 1) ? ' style="display:none;"':''; ?> id="send_by_gmail">
                        <div class="col-4"><?= $form->field($model, 'smtp_email')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-4"><?= $form->field($model, 'smtp_pass')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-4"><?= $form->field($model, 'smtp_host')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-4"><?= $form->field($model, 'smtp_port')->textInput(['maxlength' => true]) ?></div>
                        <div class="col-4"><?= $form->field($model, 'smtp_secure')->textInput(['maxlength' => true]) ?></div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="white_bg vina-right" style="padding-bottom: 0;">
                <div class="container-fluid">


                    <!-- Begin tải ảnh đại diện -->
                    <strong class="title_box">Favicon</strong>
                    <div class="row">
                        <div class="col-12">
                           <div class="temp_img">
                              <img style="max-width: 35%;" src="<?=(($model->favicon) ? (Yii::$app->urlManagerFrontend->baseUrl.'/'.$model->favicon) : 'images/choose_img.jpg'); ?>" data-noimage="images/choose_img.jpg" />
                              <?= $form->field($model, 'file')->fileInput()->label(false); ?>
                              <?= $form->field($model, 'favicon')->hiddenInput()->label(false); ?>
                              <a href="#">Xóa</a>
                           </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>

    <div class="text-right">
        <?= Html::submitButton('<i class="far fa-save"></i> Lưu lại', ['class' => 'btn btn-info rounded-sm']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
