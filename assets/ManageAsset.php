<?php
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ManageAsset extends AssetBundle
{
    public $basePath = '@resPath';
    public $baseUrl = '@resUrl';
    public $css = [
        'css/manage.css',
        'css/font-awesome.min.css'
    ];
    public $js = [
        'js/manage.js',
        '//cdn.bootcss.com/echarts/4.1.0/echarts-en.common.js'
    ];
    public $jsOptions = [
        'position'=>View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
