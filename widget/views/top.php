<?php
use yii\helpers\Url;
?>
<!-- 头部开始 -->
<div id="top-navi">
    <image src="<?=$company->imageUrl;?>" class="top-image-width"/>
</div>
<div class="top-title">
    <a href="<?=Url::to(['default/index']);?>" title="网站首页" class="menu">网站首页</a>
    <a href="<?=Url::to(['article/list']);?>" title="新闻中心" class="menu">新闻中心</a>
    <a href="<?=Url::to(['default/contactus']);?>" title="联系我们" class="menu">联系我们</a>
    <a href="<?=Url::to(['company/message']);?>" title="在线留言" class="menu">在线留言</a>
</div>
<!-- 头部结束 -->