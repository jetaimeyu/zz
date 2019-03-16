<?php
namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0xafd4f9,
                'height' => 34,
                'width' => 65,
                'padding' => 1,
                'minLength' => 4,
                'maxLength' => 4
            ]
        ];
    }

    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('/home/default/index');
    }
}
