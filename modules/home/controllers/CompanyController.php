<?php
namespace app\modules\home\controllers;

use app\models\Company;
use app\models\LeaveMessage;
use app\models\Link;
use yii\web\Controller;
use yii\captcha\CaptchaValidator;
use Yii;

class CompanyController extends Controller
{
    public $_companyId;

    public function init()
    {
        $this->_companyId = Yii::$app->params['companyId'];
        if(!$this->_companyId) {
            $this->redirect('error');
        }
    }

    /**
     *  在线留言
     */
    public function actionMessage()
    {
        $company = Company::getInfoById($this->_companyId);
        $link = Link::getArrayForCompany();
        $model = new LeaveMessage();
        if(Yii::$app->request->isPost) {//验证验证码
            $code = $_POST['LeaveMessage']['verifyCode'];
            //实例化一个验证码验证对象
            $cpValidate = new CaptchaValidator();
            //配置action为当前的
            $cpValidate->captchaAction = '/site/captcha';
            //创建一个验证码对
            $cpAction = $cpValidate->createCaptchaAction();
            //读取验证
            $scode = $cpAction->getVerifyCode();
            if($code == $scode) {
                $data = $_POST['LeaveMessage'];
                $cache = Yii::$app->cache;
                if($cache->get(LeaveMessage::$cacheMessage . Yii::$app->params['companyId'] . $data['title'] . $data['name'] . $data['content'])) {
                    echo '<script>alert("您的信息已提交")</script>';
                }
                $model->name = $data['name'];
                $model->email = $data['email'];
                $model->content = $data['content'];
                $model->title = $data['title'];
                $model->mobile = $data['mobile'];
                if($model->save()) {
                    echo '<script>alert("提交成功")</script>';
                } else {
                    echo '<script>alert("提交失败")</script>';
                }
            } else {
                echo '<script>alert("验证码不正确")</script>';
            }
        }

        return $this->render('message', [
            'company' => $company, 'link' => $link, 'model' => $model,
        ]);
    }
}