<?php
use yii\widgets\LinkPager;
use \yii\helpers\Url;
use app\models\Area;
$this->title = '留言列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="pull-left text-muted" style="padding-top:5px; padding-left:5px;"><label>总计<span class="count-page"><?=$pages->totalCount;?></span>条记录</label></div>
        <form class="form-inline pull-right" method="get" action="">
            <div class="form-group">
                <input type="text" name="mobile" class="form-control input-sm" placeholder="联系电话" value="<?=$mobile;?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">查询</button>
        </form>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <tr>
                <th width="45" class="text-right">ID</th>
                <th class="text-center">姓名</th>
                <th class="text-center">email</th>
                <th class="text-center">联系电话</th>
                <th class="text-center">留言标题</th>
                <th class="text-center">留言内容</th>
                <th width="150" class="text-center">创建时间</th>
            </tr>
            <?php if($data):?>
                <?php foreach($data as $model):?>
                    <tr>
                        <td class="text-right"><?=$model->id;?>.</td>
                        <td class="text-center"><?=$model->name;?></td>
                        <td class="text-center"><?=$model->email;?></td>
                        <td class="text-center"><?=$model->mobile;?></td>
                        <td class="text-center"><?=$model->title;?></td>
                        <td class="text-center"><?=$model->content;?></td>
                        <td class="text-center"><?=date('Y-m-d H:i:s', $model->create_time);?></td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="8" class="text-center"><strong>没有数据记录</strong></td>
                </tr>
            <?php endif;?>
        </table>
        <div class="text-center">
            <?= LinkPager::widget(['pagination' => $pages]); ?>
        </div>
    </div>
</div>


