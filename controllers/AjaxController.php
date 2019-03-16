<?php
namespace app\controllers;

use app\models\Area;
use yii\web\Controller;

class AjaxController extends Controller
{
	public function filters()
	{
		return array(
			'ajaxOnly + areaoption',
		);
	}

    /**
     * 获取地区option
     */
    public function actionAreaoption()
    {
        $parentId = intval($_POST['parent_id']);
        $default = $_POST['d'];
        $html = '';
        if ($default) {
            $html .= '<option value="0">' . $default . '</option>';
        }
        if ($parentId > 0) {
            $array = Area::getArrayForInput($parentId);
            foreach ($array as $key=>$value) {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        echo $html;
    }
}