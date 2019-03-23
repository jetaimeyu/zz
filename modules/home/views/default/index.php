<?php
$this->title = '济南承兑汇票贴现，济南电子承兑汇票贴现，济南银行承兑汇票贴现';
use yii\helpers\Url;
use app\widget\TopWidget;
use app\widget\LeftWidget;
use app\widget\FooterWidget;
?>
<?=TopWidget::widget(['company' => $company]);?>
<div class="page-body">
    <!-- 左侧开始 -->
    <?=LeftWidget::widget(['company' => $company, 'center' => $center, 'type' => 'default',]);?>
    <!-- 左侧结束 -->
    <!-- 右侧结束 -->
    <div class="right-body fl ">
        <div class="">
            <div style="margin-bottom: 10px;">
                <div class="body-title-3 left-margin-top10 fl"></div>
                <div class="body-title-1 left-margin-top10 fl">公司简介</div>
                <div class="body-title-2 left-margin-top10 fl"></div>
                <div class="clear"></div>
            </div>
            <div class="right_line-1"></div>
            <div class="right_line-5"></div>

            <div class="company-text fl">
                    <span>
                        <p>提供服务：<strong><?=$company->slogan?></strong></p>
                        <p><?=nl2br($company->description);?></p>
                    </span>
            </div>
            <div class="fr right-image">
                <image class="img-img" src="<?=$company->describeImageUrl;?>"/>
            </div>
            <div class="clear"></div>
        </div>

        <div class="">
            <div style="margin-bottom: 10px;">
                <div class="body-title-3 left-margin-top10 fl"></div>
                <div class="body-title-1 left-margin-top10 fl">公司新闻</div>
                <div class="body-title-2 left-margin-top10 fl"></div>
                <div class="fr right-info">
                    <a href="<?=Url::to(['article/list'])?>">[详细]</a>
                </div>
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

        </div>

        <div class="">
            <div style="margin-bottom: 10px;">
                <div class="body-title-3 left-margin-top10 fl"></div>
                <div class="body-title-1 left-margin-top10 fl">推荐产品</div>
                <div class="body-title-2 left-margin-top10 fl"></div>
                <div class="fr right-info">
                    <a href="<?=Url::to(['article/list'])?>">[详细]</a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="right_line-1"></div>
            <div class="right_line-5"></div>
            <div class="product-list">
                <?php foreach ($push as $k => $v):?>
                    <a href="<?=Url::to(['article/index', 'id' => $k])?>" class="fl">
                        <image class="image-product" src="<?=$v['image']?>"/>
                        <div class="text-product"><?=$v['name']?></div>
                    </a>
                <?php endforeach;?>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <!-- 右侧结束 -->
    <div class="clear"></div>
<?=FooterWidget::widget(['company' => $company, 'link' => $link,]);?>