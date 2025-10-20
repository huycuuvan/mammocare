<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
//        '//fonts.googleapis.com/css?family=Roboto:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap&subset=vietnamese',
//        '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        'bundle/plugins/boostrap/bootstrap.min.css',
        '//use.fontawesome.com/releases/v5.11.2/css/all.css',
//        '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
//        '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
        'bundle/plugins/slick/slick.min.css',
        'bundle/plugins/slick/slick-theme.min.css',
        'bundle/plugins/owlcarousel/assets/owl.carousel.min.css?v=1488314592',
        'bundle/plugins/owlcarousel/assets/owl.theme.default.min.css',
        'bundle/plugins/mmenu/mmenu.css',
//        'bundle/plugins/fancybox/jquery.fancybox.min.css',
        'bundle/plugins/amaran/css/amaran.min.css',
        'bundle/css/style.scss',
        'bundle/css/customize.css'
    ];
    public $js = [
//        '//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
//        '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
//        '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        'bundle/js/jquery.min.js',
        'bundle/js/popper.min.js',
        'bundle/plugins/boostrap/bootstrap.min.js',
        'bundle/plugins/slick/slick.min.js',
//        '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        'bundle/plugins/owlcarousel/owl.carousel.js',
        'bundle/plugins/geometryangle/geometryangle.js',
        'bundle/plugins/amaran/js/jquery.amaran.min.js',
        'bundle/plugins/mmenu/mmenu.js',
        'bundle/js/app.js',
        'bundle/js/custom.js',
    ];
    public $depends = [
        // 'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}

