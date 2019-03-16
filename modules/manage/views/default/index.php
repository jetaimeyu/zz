<?php
use yii\helpers\Url;

$this->params['breadcrumbs'][] = '管理主页';
$this->title = '管理主页';
?>
<style>
    .panel {background: transparent;}
    .panel-body {background:#fff;}
    .panel-body .title {border-bottom: 2px solid #efefef; font-size:14px; line-height: 30px; font-weight: bold;}
    .panel-body .table {color:#666;}
    .panel-body .table > thead > tr > th, .panel-body .table > tbody > tr > th, .panel-body .table > tfoot > tr > th, .panel-body .table > thead > tr > td, .panel-body .table > tbody > tr > td, .panel-body .table > tfoot > tr > td{border-top:0px;}
    .panel-body .table > thead > tbody > tr, .panel-body .table > tbody > tr {border-top: 1px solid #efefef;}

    .panel-body .static-div {width:25%; line-height: 25px; text-align: center; margin:15px 0px;}
    #qrcode-link img {position: absolute; border:1px solid #efefef; top:-65px; display: none;}
    #echart-body { width:100%; height:200px;}
</style>
<div class="col-sm-6" style="padding-left: 0px; padding-right:7px;">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="title">
                基本信息
            </div>
            <table class="table table-hover">
                <tr style="border: 0px;">
                    <td width="85" class="text-right">企业名称:</td>
                    <td>
                        <?=$company->name;?>
                        <a href="javascript:void(0);" id="qrcode-link"><img src="<?=$company->imageUrl;?>" width="120" height="120" /><span class="fa fa-qrcode"></span></a>
                    </td>
                </tr>
                <tr>
                    <td class="text-right">简短标语:</td>
                    <td><?=$company->slogan;?></td>
                </tr>
                <tr>
                    <td class="text-right">介绍:</td>
                    <td><?=nl2br($company->description);?></td>
                </tr>
                <tr>
                    <td class="text-right">注册时间:</td>
                    <td><?=date('Y-m-d H:i', $company->create_time);?></td>
                </tr>
                <tr hidden>
                    <td class="text-right">服务期间:</td>
                    <td><?=date('Y-m-d', $company->create_time);?> - <?=date('Y-m-d', $company->service_time);?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-6" style="padding-right: 0px; padding-left:7px;">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="title">
                联系方式
            </div>
            <table class="table table-hover">
                <tr style="border: 0px;">
                    <td width="120" class="text-right">企业联系电话:</td>
                    <td><?=$company->mobile;?></td>
                </tr>
                <tr>
                    <td class="text-right">企业邮箱:</td>
                    <td><?=$company->email;?></td>
                </tr>
                <tr>
                    <td class="text-right">企业微信号:</td>
                    <td><?=$company->weixin;?></td>
                </tr>
                <tr>
                    <td class="text-right">企业QQ号:</td>
                    <td><?=$company->qq;?></td>
                </tr>
                <tr>
                    <td class="text-right">企业地址:</td>
                    <td><?=$company->addressText;?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 text-center" style="margin-top: 20px;">
    <a href="<?=Url::to(['company/setting']);?>" class="btn btn-sm btn-primary">&nbsp;&nbsp;修改资料&nbsp;&nbsp;</a>
</div>