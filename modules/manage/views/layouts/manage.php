<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\ManageAsset;
use yii\widgets\Breadcrumbs;

ManageAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="menu">
    <div class="menu-title">承兑汇票&nbsp;&nbsp;</div>
    <ul class="menu-list">
        <li <?=$this->context->id == 'default' ? ' class="selected"' : '';?>><a href="<?=Url::to(['default/index']);?>"><span class="fa fa-fw fa-dashboard"></span> 管理主页</a></li>
        <li <?=$this->context->id == 'company' ? ' class="selected"' : '';?>><a href="<?=Url::to(['company/setting']);?>"><span class="fa fa-fw fa-cog"></span> 基本资料</a></li>
        <li <?=$this->context->id == 'article' ? ' class="selected"' : '';?>><a href="<?=Url::to(['article/index']);?>"><span class="fa fa-fw fa-calendar-o"></span> 文章管理</a></li>
        <li <?=$this->context->id == 'link' ? ' class="selected"' : '';?>><a href="<?=Url::to(['link/link']);?>"><span class="fa fa-fw fa-link"></span> 友情链接</a></li>
        <li <?=$this->context->id == 'message' ? ' class="selected"' : '';?>><a href="<?=Url::to(['message/index']);?>"><span class="fa fa-fw fa-envelope-open-o"></span> 留言列表</a></li>
    </ul>
    <div class="menu-footer">
        软件版本 <?=Yii::$app->params['webVersion'];?>
        <br>
        &copy;2018
    </div>
</div>
<div class="wrap">
    <div class="wrap-header">
        <div class="dropdown">
            <img src="<?=Yii::$app->session->get('companyImage');?>" width="35" height="35" style="border-radius: 18px;">
            <a class="dropdown-toggle" id="userInfoMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <?=Yii::$app->session->get('companyName');?>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userInfoMenu1">
                <li><a href="<?=Url::to(['company/profile']);?>">我的信息</a></li>
                <li><a href="<?=Url::to(['company/password']);?>">修改密码</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?=Url::to(['default/logout']);?>">退出</a></li>
            </ul>
        </div>
    </div>
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'homeLink' => ['label'=>'<strong>主页</strong>', 'url'=>Url::to(['default/index']), 'encode'=>false]
    ]);?>
    <div class="wrap-content">
        <?=$content;?>
    </div>
</div>
<div class="alert-message">
    <span id="alertMessage">
        <i class=""></i> <span></span>
    </span>
</div>
<script>
    <?php if(Yii::$app->session->getFlash('alertMessage')):?>
    showMessage('<?=Yii::$app->session->getFlash('alertMessage')?>', 3);
    <?php endif;?>
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
