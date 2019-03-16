<?php
namespace app\modules\home;
use Yii;

class home extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\home\controllers';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
        \Yii::$app->errorHandler->errorAction = 'home/default/error';
    }

    public function beforeAction($action)
    {
        if(parent::beforeAction($action))
        {
            return true;
        }
        else
            return false;
    }
}
