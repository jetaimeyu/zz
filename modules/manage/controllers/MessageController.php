<?php
namespace app\modules\manage\controllers;

use app\models\LeaveMessage;
use yii\web\Controller;
use Yii;

class MessageController extends Controller
{
    public function actionIndex()
    {
        $mobile = Yii::$app->request->get('mobile');
        $where = [];
        if( $mobile) {
            $where[][] = ['mobile' => $mobile];
        }
        $data = LeaveMessage::getDataList($where, 20, 'create_time desc');
        $model = $data['data'];
        $pages = $data['pages'];
        return $this->render('index', ['pages' => $pages, 'data' => $model, 'mobile' => $mobile]);
    }
}