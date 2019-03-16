<?php
namespace app\modules\home\controllers;

use app\models\ArticleJoin;
use app\models\Articles;
use app\models\Company;
use app\models\Link;
use yii;
use yii\web\Controller;

class ArticleController extends Controller
{
    public $_companyId;

    public function init()
    {
        $this->_companyId = Yii::$app->params['companyId'];
        if(!$this->_companyId) {
            $this->redirect('error');
        }
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
        $company = Company::getInfoById($this->_companyId);
        //公司新闻
        $news = Articles::getNewList();

        $id = $_GET['id'];
        $model = Articles::find()->andWhere(['company_id' => $this->_companyId, 'id' => $id, 'is_show' => STATE_YES])->one();
        if(!$id || !$model) {
            return $this->redirect('default/error');
        }
        //相关文章
        $center = [];
        $centerJoin = ArticleJoin::getIds($id);
        if($centerJoin) {
            foreach ($centerJoin as $v) {
                $center[$v]['name'] = Articles::getNameById($v);
            }
        }


        //上一篇
        $lastNext = Articles::getLastAndNextOneById($id);

        $link = Link::getArrayForCompany();

        return $this->render('index', [
            'company' => $company, 'news' => $news, 'link' => $link,
            'model' => $model, 'lastNext' => $lastNext, 'center' => $center,
        ]);
    }

    /**
     * 新闻中心
     * @return string
     */
    public function actionList()
    {
        $company = Company::getInfoById($this->_companyId);
        //产品中心
        $center = Articles::getListByCategory(Articles::PRODUCT_CENTER);
        //公司新闻
        $news = Articles::getListByCategory(Articles::COMPANY_NEWS);
        //推荐产品
        $push = Articles::getListByCategory(Articles::PUSH_PRODUCT);

        $link = Link::getArrayForCompany();

        return $this->render('list', [
            'company' => $company, 'center' => $center, 'push' => $push, 'news' => $news, 'link' => $link,
        ]);
    }
}
