<?php
namespace app\widget;

use yii\base\Widget;

class TopWidget extends Widget
{
    public $company;//企业信息 ['首图']

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('top', [
            'company' => $this->company,
        ]);
    }
}