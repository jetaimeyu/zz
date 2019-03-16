<?php
namespace app\widget;

use yii\base\Widget;

class LeftWidget extends Widget
{
    public $company;//企业信息
    public $center;//产品中心
    public $news;//新闻列表
    public $type;//当前页面的类型

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('left', [
            'company' => $this->company, 'center' => $this->center, 'news' => $this->news, 'type' => $this->type,
        ]);
    }
}