<?php
namespace app\modules\manage;
use Yii;

class manage extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\manage\controllers';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
        \Yii::$app->errorHandler->errorAction = 'manage/default/error';
    }

    public function beforeAction($action)
    {
        if(parent::beforeAction($action))
        {
            if ($action->controller->id == 'default' && in_array($action->id, array('login', 'logout'))) {
                // 这里是不需要登陆验证的
                if($action->id == 'login') {
                    $session = Yii::$app->session;
                    if($session['companyId'] && $session['companyName']) {
                        $action->controller->redirect(['default/index']);
                    }
                }
            } else {
                $session = Yii::$app->session;
                if(!$session['companyId'] || !$session['companyName']) {
                    $action->controller->redirect(['default/login']);
                    Yii::$app->end();
                }
//                $action->controller->redirect(['default/login']);
            }
            return true;
        }
        else
            return false;
    }
}
