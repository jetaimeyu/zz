<?php
namespace app\modules\manage\controllers;

use app\models\Company;
use app\models\CompanyLog;
use app\models\Link;
use yii\helpers\FileHelper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class LinkController extends  Controller
{
    public $_companyId = 0;
    public function init()
    {
        $this->_companyId = Yii::$app->session['companyId'];
    }

    /**
     * 友情链接
     */
    public function actionLink()
    {
        $id = Yii::$app->request->get('id');
//        $id = intval($_GET['id']);
        $model = null;
        if ($id) {
            $model = Link::findOne($id);
            if ($model && $model->company_id != $this->_companyId) {
                $this->redirect(['default/error']);
                Yii::$app->end();
            }
        }
        if (!$model) {
            $model = new Link();
            $model->company_id = $this->_companyId;
            $model->sort = 0;
        }
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Link');
            $model->name = trim($postData['name']);
            $model->url = trim($postData['url']);
            $model->sort = trim($postData['sort']);

            if ($model->save()) {
                Yii::$app->session->setFlash('alertMessage', '文章友情链接’'.$model->name.'’已成功保存!');
                if($id > 0) {
                    $this->redirect(['link', 'id'=>$model->id]);
                    CompanyLog::addLog('修改文章友情链接 id：'. $id);
                } else {
                    $this->redirect(['link']);
                    CompanyLog::addLog('添加文章友情链接 id：'. $id);
                }
            }
        }

        $data = Link::find()->where(['company_id'=>$this->_companyId])->orderBy('sort desc, id desc')->all();

        return $this->render('link', ['companyId'=>$this->_companyId, 'data'=>$data, 'model'=>$model]);
    }

    /**
     * 删除友情链接
     */
    public function actionDelete()
    {
        $id = intval($_GET['id']);
        $model = Link::findOne($id);
        if($model && $model->company_id == $this->_companyId) {
            if($model->delete()) {
                Yii::$app->session->setFlash('alertMessage', '文章分类’'.$model->name.'’已成功删除!');
                CompanyLog::addLog('删除文章分类 id：'. $id);
            }
        }
        $this->redirect(Yii::$app->request->referrer);
    }
}