<?php
use yii\helpers\Url;
?>
<!-- 底部开始 -->
<div class="footer">
    <div class="footer-img"></div>
    <div class="link">友情链接:
        <?php foreach ($link as $k => $v):?>
            <a href="<?=$v['url'];?>"><?=$v['name'];?></a>
        <?php endforeach;?>
    </div>
</div>
<!-- 底部结束 -->
</div>
<div class="page-other">
    <div class="footer-content">
        <a href="<?=Url::to(['/home/default/index'])?>">网站首页</a>
        <div class="footer-text">2009-<?=date('Y');?> 济南承兑汇票贴现</div>
    </div>
</div>
