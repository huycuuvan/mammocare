<div class="hotline-widget">

    <a class="hotline" href="tel:<?= $cont->hotline ?>" style="display: flex; align-items: center;">
        <i class="fas fa-phone-alt"></i>
        <div>

            <p style="margin-bottom: 4px; margin-top: 5px; line-height: 1; font-weight: 400; font-size: 13px">HOTLINE</p>
            <span>
        <?= $cont->hotline ?>

      </span>

        </div>
    </a>
    <?php if($conf->zalo_url){?>
    <a href="<?= $conf->zalo_url ?>" class="zalo" target="_blank">
        <img src="upload/zalo.png" alt="zalo">
    </a>
    <?php
    }
    ?>
</div>

<div class="hotline-widget-mobile">

    <a href="<?= $conf->zalo_url ?>" class="zalo-mobile d-none" target="_blank">
        <img src="upload/zalo.png" alt="zalo">
        <span><?= Yii::t('app', 'chat-tvv') ?></span>
    </a>
    <span class="btn btn-primary zalo-mobile" data-toggle="modal" data-target="#exampleModal">
        <i class="far fa-calendar-alt"></i> Đặt lịch khám
    </span>
    <a class="hotline" href="tel:<?= $cont->hotline ?>" style="display: flex; align-items: center;">
        <i class="fas fa-phone-alt"></i>
        <?= Yii::t('app', 'call-now') ?>
    </a>

</div>


<style>
    .zalo {
        background: white !important;
        position: fixed;
        /*left: 0 !important;*/
        bottom: 20px;
        z-index: 50;
        display: inline-block;
        line-height: 40px;
        height: 45px !important;
        width: 45px;
        border-radius: 50% !important;
        color: #fff;
        padding: 0px !important;
    }
    .hotline-widget .hotline{
        left: 80px!important;
    }
    .zalo img {
        width: 45px;
    }
    .hotline-widget-mobile{display: none;}
    @media (max-width: 768px) {
        .hotline-widget {
            display: none !important;
        }

        .hotline-widget-mobile {
            position: fixed;
            bottom: 0;
            left: 0;
            height: 50px;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
            padding: 5px;
            display: flex;
        }

        .hotline-widget-mobile a{
            display: inline-block;
            border-radius: 3px;
        }

        .hotline-widget-mobile .hotline{
            width: 35%;
            background: #3fb801;
            color: white;
            font-size: 16px;
            justify-content: center;
        }
        .hotline-widget-mobile .hotline i{
            margin-right: 5px;
        }

        .hotline-widget-mobile .zalo-mobile{
            width: 65%;
            background-color: #0082d0;
            text-align: center;
            padding-top: 6px;
            margin-right: 5px;
        }

        .hotline-widget-mobile .zalo-mobile span{
            color: white;
            font-size: 16px;
        }

        .hotline-widget-mobile .zalo-mobile img{
            width: 20px;
        }

    }
</style>