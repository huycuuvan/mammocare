<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,600,600i,700,700i,800,800i',
        '../asset-builder/minimalist-blocks/content.css',
        'contentbuilder/contentbuilder.css',
        '../bundle/plugins/bootstrap/bootstrap-datepicker.min.css?v=1558355210',
        'css/style.scss',
        'css/customize.css',
        'select2/css/select2.min.css'
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    public $js = [
        'js/fontawesome-all.js',
        'https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.min.js',
        'https://cdn.jsdelivr.net/npm/litepicker@2.0.12/dist/litepicker.js',
        '../bundle/js/bootstrap-datepicker.min.js?v=1587962084',
        'select2/js/select2.min.js',
        'js/bootstrap.min.js',
        'js/jquery-sortable.js',
        'js/tagsinput.js',
        'contentbuilder/contentbuilder.min.js',
        'contentbuilder/lang/vi.js',
        '../asset-builder/minimalist-blocks/content.js',
        'js/app.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];
}
