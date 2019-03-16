<?php

$params = require(__DIR__ . '/params_'.YII_ENV.'.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'aliases' => [
        '@uploadPath' => dirname(__DIR__) . '/web/uploads/',
        '@uploadUrl' => $params['uploadUrl'],
        '@resPath' => dirname(__DIR__) . '/web/resources/',
        '@resUrl' => $params['resUrl']
    ],
    'modules' => [
        'manage' => [
            'class' => 'app\modules\manage\manage',
            'layout' => 'manage'
        ],
        'home' => [
            'class' => 'app\modules\home\home',
            'layout' => 'home'
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gHZNf4ODnMz_k1Vfm4CsC4UONuSxnaGU',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        //前端资源(Assets)
        'assetManager' => [
            'basePath' => '@resPath/assets',
            'baseUrl' => '@resUrl/assets',
            'appendTimestamp' => true,
        ],
        //路由
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:dbname=' . $params['db']['dbName'] . ';host=' . $params['db']['host'],
            'username' => $params['db']['username'],
            'password' => $params['db']['password'],
            'charset' => $params['db']['charset'],
            'enableSchemaCache' => $params['db']['enableSchemaCache'],
            'tablePrefix' => $params['db']['tablePrefix'],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'redisCache' => [
//            'class' => 'yii\redis\Cache',
//            'redis' => [
//                'hostname' => $params['redis']['hostname'],
//                'port' => $params['redis']['port'],
//                'database' => $params['redis']['database'],
//                'password' => $params['redis']['password'],
//            ]
//        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
}
// 管理员菜单项
$config['params']['adminMenu'] = [
    'goods' => [
        'label' => '商品管理',
        'icon' => 'fa-trello',
        'subMenu' => [
            '商品信息' => 'goods/goodslist',
        ],
    ],
];

return $config;
