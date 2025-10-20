<?php
$conf = $this->params['conf'];
use backend\components\MyExt;
use yii\helpers\Url;
if(MyExt::mobileDetect()) { ?>
    <div class="bottom-wiget-support text-center p-1 d-none1">
        <div class="d-flex justify-content-around">
            <div class="item phone">
                <a href="tel:<?=$cont->hotline; ?>" target="_blank" class="d-flex justify-content-center align-items-center">
                    <img src="upload/icon-phone2.png" alt="wiget hotline" height="25" width=""/>
                    <span class="d-block"><?=$cont->hotline; ?></span>
                </a>
            </div>
            <div class="item d-none">
                <a href="sms:<?=$cont->hotline; ?>" target="_blank">
                    <img src="upload/icon-sms2.png" alt="wiget Nhắn tin" height="25" width=""/>
                    <span class="d-block"><?= Yii::t('app', 'send-message') ?></span>
                </a>
            </div>
            <?php
            if($conf->zalo_url) {
                ?>
                <div class="item zalo">
                    <a href="<?= $conf->zalo_url; ?>" target="_blank" class="d-flex justify-content-center align-items-center">
                        <img src="upload/icon-zalo2.png" alt="wiget Chat Zalo" height="25" width=""/>
                        <span class="d-block">Chat Zalo</span>
                    </a>
                </div>
                <?php
            }
            if($conf->wechat_url) {
                ?>
                <div class="item mess">
                    <a href="<?= $conf->wechat_url; ?>" target="_blank" class="d-flex justify-content-center align-items-center">
                        <img src="upload/icon-mesenger2.png" alt="wiget Chat Facebook" height="25" width=""/>
                        <span class="d-none">Chat Facebook</span>
                    </a>
                </div>
                <?php
            }
            ?>
            <div class="item uptotop">
                <a href="javascript:void(0)" id="gototop" onclick="jQuery('html,body').animate({scrollTop: 0},1000);" class="d-flex justify-content-center align-items-center">
                    <i class="fas fa-chevron-circle-up"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="bottom-support-online text-center py-0 d-none">
        <div class="d-flex justify-content-center support-content show">
            <a href="<?= Url::to(['site/contact']);?>" target="_blank" class="contact-now" rel="nofollow">
                <?= Yii::t('app','contact') ?>
            </a>
            <a href="tel:<?=$cont->hotline; ?>" class="phone-call-now" rel="nofollow">
                <i <?php if($conf->color_widget) echo 'style="background:'.$conf->color_widget.'"'?> class="fa fa-phone " aria-hidden="true"></i>
            </a>
            <?php if($conf->wechat_url) {
                ?>
                <a class="mes" href="<?= $conf->wechat_url; ?>" target="_blank">
                    <img src="upload/fb.png" alt="Messenger Chat" height="40" width="40" style="position: relative;z-index: 999"/>
                </a>
            <?php } ?>
            <?php if($conf->zalo_url) {
                ?>
                <a class="zalo d-none1" href="<?= $conf->zalo_url; ?>" target="_blank">
                    <img src="upload/zalo.png" alt="wiget Chat Zalo" height="40" width="40" style="position: relative;z-index: 999"/>
                </a>
            <?php } ?>
            <a href="javascript:void(0)" id="gototop" onclick="jQuery('html,body').animate({scrollTop: 0},1000);" >
                <i class="fas fa-angle-up"></i>
                <!-- <span>Top</span> -->
            </a>
        </div>
    </div>
    <?php
}
else {
}
?>
<div class="bottom-support-online">
    <div class="support-content show">
        <a href="<?= Url::to(['site/contact']);?>" target="_blank" class="contact-now" rel="nofollow">
            <?= Yii::t('app','contact') ?>
        </a>
        <a href="tel:<?=$cont->hotline; ?>" class="phone-call-now" rel="nofollow">
            <i <?php if($conf->color_widget) echo 'style="background:'.$conf->color_widget.'"'?> class="fa fa-phone " aria-hidden="true"></i>
            <span>Hotline: <?=$cont->hotline; ?></span>
        </a>
        <?php
        if($conf->wechat_url){
            ?>
            <a class="mes" href="<?= $conf->wechat_url; ?>" target="_blank">
                <img src="upload/fb.png" alt="Messenger Chat" height="40" width="40" style="position: relative;z-index: 999"/>
                <span><?= Yii::t('app','chat_messenger') ?></span>
            </a>
        <?php } ?>
        <?php
        if($conf->zalo_url){
            ?>
            <a class="zalo d-none1" href="<?= $conf->zalo_url; ?>" target="_blank">
                <img src="upload/zalo.png" alt="wiget Chat Zalo" height="40" width="40" style="position: relative;z-index: 999"/>
                <span><?= Yii::t('app','chat_zalo') ?></span>
            </a>
        <?php } ?>
        <a href="javascript:void(0)" id="gototop" onclick="jQuery('html,body').animate({scrollTop: 0},1000);" >
            <i class="fas fa-angle-up"></i>
            <span><?= Yii::t('app','gototop') ?></span>
        </a>
        <?php
        if($conf->viber_url){
            ?>
            <a class="mes" href="<?= $conf->viber_url; ?>" target="_blank">
                <img src="upload/Whatsapp-icon.png" alt="Whatsapp Chat"/>
            </a>
            <?php
        }
        ?>
    </div>
    <a class="btn-support d-none">
        <i <?php if($conf->color_widget) echo 'style="background:'.$conf->color_widget.'"'?> class="fa fa-bell" aria-hidden="true"></i>
        <div class="animated infinite zoomIn kenit-alo-circle"  <?php if($conf->color_widget) echo 'style="border-color:'.$conf->color_widget.'"'?>></div>
        <div class="animated infinite pulse kenit-alo-circle-fill" <?php if($conf->color_widget) echo 'style="background-color:'.$conf->color_widget.'"'?>></div>
    </a>
</div>
<?php
if($conf->color_widget)
    echo '
<style type="text/css">
    .bottom-support-online a span:before{
        border-color: transparent '.$conf->color_widget.' transparent transparent;
    }
    .phone-call-now{
        bottom: 0 !important;
    }
</style>';
?>
