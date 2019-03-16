<?php
use \yii\helpers\Url;
use \yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default col-sm-6">
    <div class="panel-body">
        <div class="pull-left text-muted" style="padding-top:5px; padding-left:5px;"><label>总计<?=count($data);?>条记录</label></div>
        <form class="form-inline pull-right" method="get" action="<?=Url::to(['index']);?>">
            <a href="<?=Url::to(['index']);?>" class="btn btn-success btn-sm"><span class="fa fa-fw fa-plus"></span> 新增分类</a>
        </form>
    </div>
    <div class="panel-body">
        <table class="table table-hover">
            <tr>
                <th class="text-left">分类名称</th>
                <th class="text-center" width="120">排序值</th>
                <th width="160" class="text-center">操作</th>
            </tr>
            <?php if($data):?>
            <?php foreach($data as $m):?>
            <tr class="data-tr">
                <td class="text-left middle"><?=$m->name;?></td>
                <td class="text-center middle"><?=$m->sort;?></td>
                <td class="text-center middle" style="line-height:34px;">
                    <a href="<?=Url::to(['index', 'id'=>$m->id])?>" class="btn btn-success btn-sm"><span class="fa fa-pencil fa-fw"></span> 编辑</a>
                    <a href="<?=Url::to(['delete', 'id'=>$m->id])?>" class="delete-btn btn btn-danger btn-sm confirmLink" confirmMessage="确定要删除分类“<?=$m->name;?>”吗？"><span class="fa fa-trash-o fa-fw"></span> 删除</a>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?>
            <tr>
                <td colspan="3" class="text-center"><strong>没有数据记录</strong></td>
            </tr>
            <?php endif;?>
        </table>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-default" style="padding:15px 0px;">
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-2',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-9',
                    'error' => '',
                    'hint' => '',
                ],
            ],
            'options' => ['enctype' => 'multipart/form-data', 'id'=>'postForm']
        ]); ?>
        <?= $form->field($model, 'name', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm']); ?>
        <?= $form->field($model, 'sort', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['class'=>'form-control input-sm'])->hint('排序值:越大越靠前') ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <?= Html::submitButton($model->isNewRecord ? '增加分类' : '编辑分类', ['class' => 'btn btn-sm ' . ($model->isNewRecord ? 'btn-success' : 'btn-primary')]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>