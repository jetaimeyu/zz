<?php
define('STATE_YES', 1);
define('STATE_NO', 0);

return [
    'domain' => 'http://yuyuyu.dev.cn/',
    'uploadUrl' => 'http://yuyuyu.dev.cn/',
    'resUrl' => 'http://yuyuyu.dev.cn/resources/',
    'db' => [
        'dbName' => 'web_yuyuyu',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'enableSchemaCache' => false,
        'tablePrefix' => 'w_',
    ],
    'webVersion' => '1.0.1',
    'companyId' => '1',
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
];