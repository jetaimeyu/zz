<?php
$params = require __DIR__ . '/params_'.YII_ENV.'.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'language' => 'zh-CN',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
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
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => $params['redis']['hostname'],
                'port' => $params['redis']['port'],
                'database' => $params['redis']['database'],
                'password' => $params['redis']['password'],
            ]
        ]
    ],
    'params' => $params,
];
return $config;
