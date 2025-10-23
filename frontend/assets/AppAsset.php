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
        '//fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald:wght@200;300;400;500;600;700&display=swap',
        '//fonts.googleapis.com/css2?family=Muli:wght@200;300;400;500;600;700;800;900&display=swap',
        '//fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap',
        '//fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap',
        // '//fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900&display=swap',
        // '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&display=swap&subset=vietnamese',
        // '//fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
        // '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        // '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css',
        // '//use.fontawesome.com/releases/v5.11.2/css/all.css',
        'asset-builder/minimalist-blocks/content.css',
        'bundle/plugins/bootstrap/bootstrap.min.css',
        'bundle/plugins/bootstrap/bootstrap-datepicker.min.css',
        'bundle/plugins/fontawesome/css/all.min.css',
        'bundle/plugins/owlcarousel/assets/owl.carousel.min.css?v=1488314592',
        'bundle/plugins/owlcarousel/assets/owl.theme.default.min.css',
        'bundle/plugins/mmenu/mmenu.css',
        'bundle/plugins/fancybox/jquery.fancybox.min.css',
        'bundle/plugins/aos/aos.css',
        '//cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css',
        '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
        'bundle/css/style.css',
        'bundle/css/phone.css',
        'bundle/css/customize.css',
    ];
    public $js = [
        // '//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
        // '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js',
        // '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        // '//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        // '//cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js',
        // '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js',
        'bundle/js/jquery.min.js',
        'bundle/js/popper.min.js',
        'bundle/plugins/bootstrap/bootstrap.min.js',
        // 'bundle/js/jquery-ui.min.js',
        'bundle/js/lazysizes.min.js',
        'bundle/js/bootstrap-datepicker.min.js',
        '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        'bundle/plugins/owlcarousel/owl.carousel.min.js',
        'bundle/plugins/fancybox/jquery.fancybox.min.js',
        'bundle/plugins/mmenu/mmenu.js',
        'bundle/js/jquery.countTo.js',
        'bundle/js/jquery.animateNumbers.js',
        'bundle/plugins/aos/aos.js',
        'bundle/plugins/toc/jquery.erToc.min.js',
        'bundle/js/app.js',
        'bundle/js/custom.js',
        'bundle/js/search.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    // public $jsOptions = ['async' => 'async'];
    // public $jsOptions = ['defer' => 'defer'];
}
