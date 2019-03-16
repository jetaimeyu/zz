<?php
$this->title = '新闻中心';
use yii\helpers\Url;
use app\widget\TopWidget;
use app\widget\LeftWidget;
use app\widget\FooterWidget;
?>
<?=TopWidget::widget(['company' => $company]);?>
<div class="page-body">
    <?=LeftWidget::widget(['company' => $company, 'center' => $center, 'type' => 'articleList',]);?>
    <div class="right-body fl ">
        <div class="">
            <div>
                <div class="body-title-3 left-margin-top10 fl"></div>
                <div class="body-title-1 left-margin-top10 fl">新闻中心</div>
                <div class="body-title-2 left-margin-top10 fl"></div>
                <div class="clear"></div>
            </div>
            <div class="right_line-1"></div>
            <div class="right_line-5"></div>

            <?php foreach ($news as $k => $v):?>
                <div class="list">
                    <div class="list-image fl"></div>
                    <div class="list-name-right fl">
                        <a href="<?=Url::to(['article/index', 'id' => $k])?>"><?=$v['name'];?></a>
                    </div>
                    <div class="fr list-time"><?=date('Y-m-d H:i', $v['time'])?></div>
                    <div class="clear"></div>
                </div>
            <?php endforeach;?>

            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
<?=FooterWidget::widget(['company' => $company, 'link' => $link,]);?>