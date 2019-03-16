<?php
namespace app\modules\manage\controllers;

use app\models\Company;
use app\models\CompanyLog;
use app\models\Link;
use function PHPSTORM_META\type;
use yii\helpers\FileHelper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

class CompanyController extends  Controller
{
    public $_companyId = 0;
    public function init()
    {
        $this->_companyId = Yii::$app->session['companyId'];
    }

    /**
     * 企业设置
     */
    public function actionSetting()
    {
        $model = Company::findOne($this->_companyId);

        if ($model->load(Yii::$app->request->post())) {
            $delFile = [];

            $model->imageUpload = UploadedFile::getInstance($model, 'imageUpload');
            if ($model->imageUpload && $model->validate(['imageUpload'])) {
                $delFile[] = $model->image ? $model->image : '';
                $model->image = $this->_companyId . '/p/' . date('Ym/d_His') . '_image_' . rand(10,99)  . '.' . $model->imageUpload->extension;
                FileHelper::createDirectory(dirname(Yii::getAlias('@uploadPath/' . $model->image)));
                $model->imageUpload->saveAs(Yii::getAlias('@uploadPath/' . $model->image));
                $model->imageUpload = null;
            }
            $model->describeImageUpload = UploadedFile::getInstance($model, 'describeImageUpload');
            if ($model->describeImageUpload && $model->validate(['describeImageUpload'])) {
                $delFile[] = $model->describe_image ? $model->describe_image : '';
                $model->describe_image = $this->_companyId . '/p/' . date('Ym/d_His') . '_image_' . rand(10,99)  . '.' . $model->describeImageUpload->extension;
                FileHelper::createDirectory(dirname(Yii::getAlias('@uploadPath/' . $model->describe_image)));
                $model->describeImageUpload->saveAs(Yii::getAlias('@uploadPath/' . $model->describe_image));
                $model->describeImageUpload = null;
            }

            if($model->save()) {
                Yii::$app->session['companyName'] = $model->name;
                Yii::$app->session['companyImage'] = $model->imageUrl;
                if($delFile) {
                    Company::deleteFile(Yii::getAlias('@uploadPath/'), $delFile);
                }
                CompanyLog::addLog('企业资料修改 企业id：'. $this->_companyId);
            }
        }

        return $this->render('setting', ['model' => $model]);
    }

    /**
     * 企业资料
     * @return string
     */
    public function actionProfile()
    {
        return $this->redirect('/manage/company/setting');
//        $model = Company::findOne($this->_companyId);
//        return $this->render('profile', ['model' => $model]);
    }

    /**
     * 修改密码
     */
    public function actionPassword()
    {
        $message = '';
        $model = Company::findOne($this->_companyId);

        if(Yii::$app->request->isPost) {
            $password = Yii::$app->request->post('password');
            $oldPassword = Yii::$app->request->post('oldPassword');
            if(md5($oldPassword) == $model->password) {
                if($password) {
                    $model->password = md5($password);
                    if($model->update()) {
                        $message = '密码修改成功!';
                        CompanyLog::addLog('企业密码修改 企业id：'. $this->_companyId);
                    }
                } else {
                    $message = '新密码不能为空!';
                }
            } else {
                $message = '原密码不正确!';
            }
        }

        return $this->render('password', ['message' => $message]);
    }
}