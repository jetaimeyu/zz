<?php

namespace app\modules\home\controllers;

use app\models\Articles;
use app\models\Company;
use app\models\CompanyLog;
use app\models\Link;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $_companyId;

    public function init()
    {
        $this->_companyId = Yii::$app->params['companyId'];
        if(!$this->_companyId) {
            $this->redirect('error');
        }
    }

//    public function actions()
//    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ]
//        ];
//    }

    public function actionError()
    {
        $this->layout = false;
        return $this->render('error');
    }

    public function actionIndex()
    {
        $company = Company::getInfoById($this->_companyId);
        //产品中心
        $center = Articles::getListByCategory(Articles::PRODUCT_CENTER);
        //公司新闻
        $news = Articles::getListByCategory(Articles::COMPANY_NEWS);
        //推荐产品
        $push = Articles::getListByCategory(Articles::PUSH_PRODUCT);

        $link = Link::getArrayForCompany();

        return $this->render('index', [
            'company' => $company, 'center' => $center, 'push' => $push, 'news' => $news, 'link' => $link,
        ]);
    }

    /**
     * 联系我们
     * @return string
     */
    public function actionContactus()
    {
        $company = Company::getInfoById($this->_companyId);
        //产品中心

        $link = Link::getArrayForCompany();

        return $this->render('contactus', [
            'company' => $company, 'link' => $link,
        ]);
    }
}
