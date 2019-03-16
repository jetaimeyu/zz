<?php
define('STATE_YES', 1);
define('STATE_NO', 0);

return [
    'domain' => 'http://yuyuyu.pyliutao.cn/',
    'uploadUrl' => 'http://yuyuyu.pyliutao.cn/',
    'resUrl' => 'http://yuyuyu.pyliutao.cn/resources/',
    'db' => [
        'dbName' => 'web_yuyuyu',
        'host' => 'pyliutao.cn',
        'username' => 'yuyuyu',
        'password' => 'yuyuyu123$',
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