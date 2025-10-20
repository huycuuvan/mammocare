<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php'
);

$rules = array_merge(
    require __DIR__ . '/../../common/config/rules.php'
);

$config = [
    'id' => 'app-backend',
    'language'=>'vi',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [

        'assetManager' => [
            'basePath' => '@webroot/yii-assets',
            'baseUrl' => '@web/yii-assets',
            
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'https://code.jquery.com/jquery-3.3.1.min.js'
                    ]
                ],
                // 'yii\bootstrap\BootstrapPluginAsset' => [
                //     'js'=>[]
                // ],
                // 'yii\bootstrap\BootstrapAsset' => [
                //     'css' => []
                // ]
            ]
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',

            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EAWYc2a1qKKWNVu9DL2eWU-mVXMPZijJ',

        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 6048000, // auth expire
            
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'timeout' => 6048000, //session expire
            'useCookies' => true,
            'cookieParams' => ['lifetime' => 7 * 24 *60 * 60]
        ],
        'log' => [
            // 'traceLevel' => YII_DEBUG ? 3 : 0,
            // 'targets' => [
            //     [
            //         'class' => 'yii\log\FileTarget',
            //         'levels' => ['error', 'warning'],
            //     ],
            // ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                ['pattern' => '', 'route' => 'site/index'],
                ['pattern' => 'login', 'route' => 'site/login'],
            ],
        ],
        'urlManagerFrontend' => [
            'baseUrl' => $params['basePath'],
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => $rules,
        ],
    ],

    'params' => $params,
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
