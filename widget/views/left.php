<?php
use yii\helpers\Url;
?>
<!-- 左侧开始 -->
<div class="left-body fl">
    <?php if($type == 'default') :?>
    <div class="left-margin-top10">
        <div class="product_center">产品中心</div>
        <div class="product_list">
            <?php if($center) :  foreach ($center as $k => $val) :?>
                <div class="list">
                    <div class="list-image fl"></div>
                    <div class="list-name-left  list-font fl">
                        <a class="" href="<?=Url::to(['article/index', 'id' => $k])?>"><?=$val['name'];?></a>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endforeach; endif;?>
        </div>
    </div>
    <?php elseif($type == 'article') :?>
    <div class="left-margin-top10">
        <div class="product_center">最新文章</div>
        <div class="product_list">
            <?php if($news) : foreach ($news as $k => $val) :?>
                <div class="list">
                    <div class="list-image fl"></div>
                    <div class="list-name-left  list-font fl">
                        <a class="" href="<?=Url::to(['article/index', 'id' => $k])?>"><?=$val['name'];?></a>
                    </div>
                    <div class="clear"></div>
                </div>

            <?php endforeach; endif;?>
        </div>
    </div>
    <div class="left-margin-top">
        <div class="product_center">相关文章</div>
        <div class="product_list">
            <?php if($center) :  foreach ($center as $k => $val) :?>
                <div class="list">
                    <div class="list-image fl"></div>
                    <div class="list-name-left  list-font fl">
                        <a class="" href="<?=Url::to(['article/index', 'id' => $k])?>"><?=$val['name'];?></a>
                    </div>
                    <div class="clear"></div>
                </div>

            <?php endforeach; endif;?>
        </div>
    </div>
    <?php endif;?>
    <div class="left-margin-top">
        <div class="product_center">联系我们</div>
        <div class="product_list_us">
            <div class="contact_us"></div>
            <div class="contact">
                <p style="margin-left: 25px;">qq：<?=$company['qq'];?></p>
                <p>电　话：<?=$company['mobile'];?></p>
                <p>地　址：<?=$company->addressText;?></p>
            </div>
        </div>
    </div>
</div>
<!-- 左侧结束 -->