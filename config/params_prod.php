<?php
define('STATE_YES', 1);
define('STATE_NO', 0);

return [
//    'domain' => 'https://jetaime.top/',
//    'uploadUrl' => 'https://jetaime.top/uploads/',
//    'resUrl' => 'https://jetaime.top/resources/',
    'domain' => 'http://zz.com/',
    'uploadUrl' => 'http://zz.com/uploads/',
    'resUrl' => 'http://zz.com/resources/',
    'db' => [
        'dbName' => 'web_yuyuyu',
        'host' => '47.93.198.167',
        'username' => 'yuyuyu',
        'password' => '123123',
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