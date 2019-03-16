<?php
namespace app\widget;

use yii\base\Widget;

class FooterWidget extends Widget
{
    public $company;//企业信息
    public $link;//企业信息

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('footer', [
            'company' => $this->company, 'link' => $this->link,
        ]);
    }
}