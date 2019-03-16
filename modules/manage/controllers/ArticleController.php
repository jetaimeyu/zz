<?php
namespace app\modules\manage\controllers;

use app\models\ArticleImage;
use app\models\ArticleJoin;
use app\models\Articles;
use app\models\CompanyLog;
use yii\data\Pagination;
use yii\helpers\FileHelper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class ArticleController extends Controller
{
    public $_companyId = 0;
    public function init()
    {
        $this->_companyId = Yii::$app->session['companyId'];
    }

    /**
     * 文章管理
     */
    public function actionIndex()
    {
        $data = Articles::find()->where(['company_id'=>$this->_companyId]);
        $name = Yii::$app->request->get('name');
        if($name) {
            $data->andWhere(['like', 'name', $name]);
        }
        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy(['sort' => SORT_DESC, 'create_time' => SORT_DESC])->all();
        return $this->render('index', ['data' => $model, 'pages' => $pages]);
    }

    public function actionAdd()
    {
        $oldImages = [];
        $oldImage = [];
        $getIds = [];
//        $id = intval($_GET['id']);
        $id = Yii::$app->request->get('id');
        if ($id) {
            $model = Articles::findOne($id);
            $getIds = ArticleJoin::getIds($id);
            if ($model->company_id != $this->_companyId) {
                $this->redirect(['default/error']);
                Yii::$app->end();
            }
            $model->update_time = time();
            $oldContent = $model->content;
            if(strrpos($oldContent, '<img')) {
                $old  = explode('<img src="http:', $oldContent);
                foreach ($old as $item => $value) {
                    if(strrpos($value, '/image/')) {
                        $oldImages[] =  explode('/image/', $value);
                    }
                }
                if($oldImages) {
                    foreach($oldImages as $image) {
                        if(strrpos($image[1], ' title="')) {
                            $image = explode(' title="', $image[1]);
                            $oldImage[] = $image[0];
                        } else if(strrpos($image[1], ' alt="')) {
                            $image = explode(' alt="', $image[1]);
                            $oldImage[] = trim(trim($image[0]), '"');
                        }
                    }
                }
            }
        }
        $articleList = Articles::getList($id);
        if (!$id) {
            $model = new Articles();
            $model->company_id = $this->_companyId;
            $model->sort = 0;
            $model->category_id = 0;
            $model->is_show = STATE_YES;
        }
        if (Yii::$app->request->isPost  && $model->load(Yii::$app->request->post())) {
            $newContent = $_POST['Articles']['content'];
            if($oldImage) {
                foreach($oldImage as $value) {
                    if(!strrpos($newContent, $value)){
                        $valuenew = trim(Yii::getAlias('@uploadPath/'.'image/'.$value), '"');
                        if(file_exists($valuenew)) {
                            unlink($valuenew);
                        }
                    }
                }
            }
            if($_POST['Articles']['sort'] != null) {
                $model->sort = $_POST['Articles']['sort'];
            } else {
                $model->sort = 0;
            }
            $model->name = $_POST['Articles']['name'];
            $model->is_show = $_POST['Articles']['is_show'];
            $model->category_id = $_POST['Articles']['category_id'];
            $model->content = $newContent;
            if ($model->save()) {
                if($_POST['Articles']['join']) {
                    foreach ($_POST['Articles']['join'] as $val) {
                        ArticleJoin::addOne($model->id, $val);
                    }
                }
                if(!$id) {
                    CompanyLog::addLog('添加文章 id：'. $id);
                    $this->redirect(['article/index']);
                } else {
                    CompanyLog::addLog('修改文章信息 id：'. $id);
                    $this->redirect(['article/index']);
                }
            } else {
                print_r($model->errors);
                exit;
            }
        }
        return $this->render('add', [
            'model' => $model, 'companyId' => $this->_companyId, 'articleList' => $articleList,
            'getIds' => $getIds,
        ]);
    }

    /**
     * 文章删除
     */
    public function actionDelete()
    {
        $oldImages = [];
        $oldImage = [];
        $id = intval($_GET['id']);
        $model = Articles::findOne($id);
        if($model && $model->company_id == $this->_companyId) {
            $oldContent = $model->content;
            if(strrpos($oldContent, '<img')) {
                $old  = explode('<img src="http:', $oldContent);
                foreach ($old as $item => $value) {
                    if(strrpos($value, '/image/')) {
                        $oldImages[] =  explode('/image/', $value);
                    }
                }
                if($oldImages) {
                    foreach($oldImages as $image) {
                        if(strrpos($image[1], ' title="')) {
                            $image = explode(' title="', $image[1]);
                            $oldImage[] = $image[0];
                        } else if(strrpos($image[1], ' alt="')) {
                            $image = explode(' alt="', $image[1]);
                            $oldImage[] = trim(trim($image[0]), '"');
                        }
                    }
                }
            }
            if($model->delete()) {
                if($oldImage) {
                    foreach($oldImage as $value) {
                        $valueNew = trim(Yii::getAlias('@uploadPath/image/'.$value), '"');
                        if(file_exists($valueNew)) {
                            unlink($valueNew);
                        }
                    }
                }
                Yii::$app->session->setFlash('alertMessage', '文章’'.$model->name.'’已成功删除!');
                CompanyLog::addLog('文章删除 id：'. $id);
            }
        }
        $this->redirect(Yii::$app->request->referrer);
    }
}