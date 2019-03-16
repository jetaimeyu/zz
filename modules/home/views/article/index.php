<?php
$this->title = '网站首页';
use yii\helpers\Url;
use app\widget\TopWidget;
use app\widget\LeftWidget;
use app\widget\FooterWidget;
?>
<!-- 头部开始 -->
<?=TopWidget::widget(['company' => $company]);?>
<!-- 头部结束 -->
<div class="page-body">
    <?=LeftWidget::widget(['company' => $company, 'news' => $news, 'center' => $center, 'type' => 'article',]);?>
    <!-- 右侧结束 -->
    <div class="right-body fl ">
        <div class="">
            <div>
                <div class="body-title-3 left-margin-top10 fl"></div>
                <div class="body-title-1 left-margin-top10 fl"></div>
                <div class="body-title-2 left-margin-top10 fl"></div>
                <div class="clear"></div>
            </div>
            <div class="right_line-1"></div>
            <div class="right_line-5"></div>

            <div class="company-text-article">
                <h3 style="text-align: center; "><?=$model->name?></h3>
                <div style="font-size: 12px; text-align: center;"><?=date('Y-m-d H:i', $model->create_time);?></div>
                <p><?=nl2br($model->content);?></p>
                <?php if($model->image) :?>
                    <?php foreach ($model->imageArray as $k => $v):?>
                        <image style="width: 300px;height: auto;" src="<?=$v?>"></image>
                    <?php endforeach;?>
                <?php endif;?>
            </div>

            <div style="margin-top: 50px;">
                <?php if($lastNext['last']['id']) :?>
                    <div class="fl">上一篇：<a href="<?=Url::to(['index', 'id' => $lastNext['last']['id']])?>"><?=$lastNext['last']['name']?></a></div>
                <?php endif;?>
                <?php if($lastNext['next']['id']) :?>
                    <div class="fr">下一篇：<a href="<?=Url::to(['index', 'id' => $lastNext['next']['id']])?>"><?=$lastNext['next']['name']?></a></div>
                <?php endif;?>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <!-- 右侧结束 -->
    <div class="clear"></div>
<?=FooterWidget::widget(['company' => $company, 'link' => $link,]);?>