<?php

namespace app\modules\manage\controllers;

use app\models\ArticleImage;
use yii\helpers\FileHelper;
use yii;
use yii\web\Controller;
use yii\helpers\Url;

/**
 * Default controller for the `company` module
 */
class UploadController extends Controller
{
    public $_companyId = 0;
    public function init()
    {
        $this->_companyId = Yii::$app->session['companyId'];
        $this->enableCsrfValidation = false;
    }

    public function actionGoodsbase64()
    {
        $data = Yii::$app->request->post('data');
        if($data) {
            $type = 'jpeg';
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data, $result)){
                $type = $result[2];
                $replaceString = $result[1];
                $data = str_replace($replaceString, '', $data);
            }
            $image = $this->_companyId . '/article/' . date('Ym/d/His') . rand(100,999) . '.' . $type;
            FileHelper::createDirectory(dirname(Yii::getAlias('@uploadPath/' . $image)));

            if(file_put_contents(Yii::getAlias('@uploadPath/' . $image), base64_decode($data))) {
                $articleImage = new ArticleImage();
                $articleImage->image = $image;
                $articleImage->article_id = 0;
                $articleImage->desc = strval(time());
                if($articleImage->save()) {
                    echo json_encode(['code'=>1, 'data'=>['id' => $articleImage->id, 'image' => $articleImage->image, 'imageUrl'=>$articleImage->imageUrl]]);
                    exit;
                }
            }
        }
        echo json_encode(['code'=>0]);
    }
}
