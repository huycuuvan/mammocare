<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=mammocare_db',
            'username' => 'mammocare_user',//
            'password' => 'Vinawebhp@2024',//
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            // Tắt asset converter để tránh lỗi dart-sass
            // 'converter' => [
            //     'class' => 'yii\web\AssetConverter',
            //     'commands' => [
            //         'scss' => ['css', 'D://dart-sass/sass {from} {to} --style compressed'],
            //         ],
            // ],
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    // 'js'=>['//code.jquery.com/jquery-2.1.4.min.js']
                ],
                'all' => [
                    'class' => 'yii\web\AssetBundle',
                    'basePath' => '@webroot/assets',
                    'baseUrl' => '@web/assets',
                    'css' => [],
                    'js' => [],
                ],
            ],
            'appendTimestamp' => true,
            'linkAssets' => false
        ],
    ],
    'modules' => [
        'hitCounter' => [
            'class' => 'coderius\hitCounter\Module',
        ],
    ],
    'bootstrap' => [
        'coderius\hitCounter\config\Bootstrap'
    ]
];