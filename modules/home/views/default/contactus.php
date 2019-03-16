<?php
$this->title = '联系我们';
use yii\helpers\Url;
use app\widget\TopWidget;
use app\widget\LeftWidget;
use app\widget\FooterWidget;
?>
<?=TopWidget::widget(['company' => $company]);?>
<div class="page-body">
    <!-- 右侧结束 -->
    <div class="fl">
        <image style="width: 220px; height: 175px; margin-top: 30px; margin-left: 20px;" src="<?=$company->describeImageUrl;?>"/>
    </div>
    <div class="company-text fl" style="height: 500px;">
        <div style="margin-top: 30px; margin-bottom: 30px;">
            <h3><?=$company->name?></h3>
            <p>电　话：<?=$company['mobile'];?></p>
            <p>邮　箱：<?=$company['email'];?></p>
            <p>微　信：<?=$company['weixin'];?></p>
            <p style="margin-left: 25px;">qq：<?=$company['qq'];?></p>
            <p>地　址：<?=$company->addressText;?></p>
        </div>
    </div>

    <div class="clear"></div>

<?=FooterWidget::widget(['company' => $company, 'link' => $link,]);?>
</div>
