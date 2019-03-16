<?php

namespace app\modules\manage\controllers;

use app\models\Company;
use app\models\CompanyLog;
use yii;
use yii\web\Controller;
use yii\helpers\Url;


class DefaultController extends Controller
{
    public $_companyId = 0;
    public function init()
    {
        $this->_companyId = Yii::$app->session['companyId'];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $company = Company::findOne($this->_companyId);

        return $this->render('index', ['company' => $company]);
    }

    public function actionLogin()
    {
        $this->layout = 'blank';
        $message = '';

        $cookies = Yii::$app->request->cookies;
        $loginName = $cookies->getValue('manageName');

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        if(Yii::$app->request->isPost) {
            $loginName = $_POST['username'];
            if($username && $password) {
                $manager = Company::find()->where(['name'=>$username, 'password'=>md5($password)])->one();
                if($manager) {
                    $session = Yii::$app->session;
                    $session['companyId'] = $manager->id;
                    $session['companyName'] = $manager->name;
                    $session['companyImage'] = $manager->getImageUrl();
                    $manager->last_login_ip = Yii::$app->request->getUserIP();
                    $manager->last_login_time = time();
                    $manager->login_count++;
                    if($manager->update()) {
                        CompanyLog::addLog('企业登陆 id:' . $manager->id);
                        $this->redirect(['default/index']);
                    }
                    $cookies = Yii::$app->response->cookies;
                    $cookies->add(new \yii\web\Cookie([
                        'name' => 'manageName',
                        'value' => $manager->name,
                        'expire'=>time() + 2592000
                    ]));
                } else {
                    $message = '输入的帐号或密码不正确';
                }
            } else {
                $message = '帐号与密码都不能为空';
            }
        }
        return $this->render('login', ['message'=>$message, 'loginName'=>$loginName]);
    }

    public function actionLogout()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->destroy();
        $this->redirect(['default/login']);
    }
}
