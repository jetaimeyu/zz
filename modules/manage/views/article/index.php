<?php
use \yii\helpers\Url;
use app\models\Articles;
use yii\widgets\LinkPager;

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="pull-left text-muted" style="padding-top:5px; padding-left:5px;"><label>总计<span class="count-page"><?=$pages->totalCount;?></span>条记录</label></div>
        <form class="form-inline pull-right" method="get" action="<?=Url::to(['index']);?>">
            <div class="form-group">
                <input type="text" name="name" class="form-control input-sm" placeholder="名称" value="<?=Yii::$app->request->get('name');?>">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">查询</button>&nbsp;&nbsp;
            <a href="<?=Url::to(['add']);?>" class="btn btn-success btn-sm">增加</a>
        </form>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <tr>
                <th width="45" class="text-right">ID</th>
                <th class="text-center">名称</th>
                <th class="text-center">分类</th>
                <th width="100" class="text-center">排序</th>
                <th width="100" class="text-center">是否展示</th>
                <th width="150" class="text-center">创建时间</th>
                <th width="230" class="text-center">操作</th>
            </tr>
            <?php if($data):?>
                <?php foreach($data as $model):?>
                    <tr>
                        <td class="text-right"><?=$model->id;?>.</td>
                        <td class="text-center"><?=$model->name;?></td>
                        <td class="text-center"><?=Articles::$category[$model->category_id];?></td>
                        <td class="text-center"><?=$model->sort;?></td>
                        <?php if($model->is_show):?>
                            <td class="text-center text-success"><?=Articles::$showStates[$model['is_show']];?></td>
                        <?php else:?>
                            <td class="text-center text-danger"><?=Articles::$showStates[$model['is_show']];?></td>
                        <?php endif; ?>
                        <td class="text-center"><?=date('Y-m-d H:i', $model['create_time']);?></td>
                        <td class="text-center">
                            <a href="<?=Url::to(['add', 'id' => $model->id]);?>" title="修改信息" class="btn-success btn-xs btn">修改信息</a>
                            <a data-href="<?=Url::to(['delete']);?>" data-val="<?=$model->id;?>" title="删除" class="btn-danger btn-xs btn delete-link"> 删除</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="7" class="text-center"><strong>没有数据记录</strong></td>
                </tr>
            <?php endif;?>
        </table>
        <div class="text-center">
            <?= LinkPager::widget(['pagination' => $pages]); ?>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.delete-link').click(function () {
            $(this).parent().parent().addClass('xuanzhong');
            var url = $(this).attr('data-href');
            var id = $(this).attr('data-val');
            var msg = '确定要删除？';
            if(confirm(msg) == true) {
                $.get(url, {id : id}, function (data) {
                    data = JSON.parse(data);
                    if(data.code != 1) {
                        alert(data.msg);
                        return false;
                    } else {
                        alert(data.msg);
                        $('.xuanzhong').remove();
                        var countList = $('.count-page').text();
                        if(countList-1 > -1) {
                            countList = countList-1;
                            $('.count-page').text(countList);
                        }
                    }
                });
            } else {
                return false;
            }
        });
    });
</script>