<?php
namespace app\modules\manage\controllers;

use app\models\ArticleCategory;
use app\models\CompanyLog;
use yii\web\Controller;
use Yii;

class CategoryController extends Controller
{
    public $_companyId = 0;
    public function init()
    {
        $this->_companyId = Yii::$app->session['companyId'];
    }

    /**
     * 分类管理
     */
    public function actionIndex()
    {
        $id = intval($_GET['id']);
        $model = null;
        if ($id) {
            $model = ArticleCategory::findOne($id);
            if ($model && $model->company_id != $this->_companyId) {
                $this->redirect(['default/error']);
                Yii::$app->end();
            }
        }
        if (!$model) {
            $model = new ArticleCategory();
            $model->company_id = $this->_companyId;
            $model->sort = 0;
        }
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('ArticleCategory');
            $model->name = trim($postData['name']);
            $model->sort = trim($postData['sort']);

            if ($model->save()) {
                Yii::$app->session->setFlash('alertMessage', '文章分类’'.$model->name.'’已成功保存!');
                if($id > 0) {
                    $this->redirect(['index', 'id'=>$model->id]);
                    CompanyLog::addLog('修改文章分类 id：'. $id);
                } else {
                    $this->redirect(['index']);
                    CompanyLog::addLog('添加文章分类 id：'. $id);
                }
            }
        }

        $data = ArticleCategory::find()->where(['company_id'=>$this->_companyId])->orderBy('sort desc, id desc')->all();

        return $this->render('index', ['companyId'=>$this->_companyId, 'data'=>$data, 'model'=>$model]);
    }

    public function actionDelete()
    {
        $id = intval($_GET['id']);
        $model = ArticleCategory::findOne($id);
        if($model && $model->company_id == $this->_companyId) {
            if($model->delete()) {
                Yii::$app->session->setFlash('alertMessage', '文章分类’'.$model->name.'’已成功删除!');
                CompanyLog::addLog('删除文章分类 id：'. $id);
            }
        }
        $this->redirect(Yii::$app->request->referrer);
    }
}