<?php
namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class HomeAsset extends AssetBundle
{
    public $basePath = '@resPath';
    public $baseUrl = '@resUrl';
    public $css = [
        'css/home.css',
    ];
    public $js = [
        'js/home.js'
    ];
    public $jsOptions = [
        'position'=>View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
