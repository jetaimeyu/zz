<?php
use yii\bootstrap\ActiveForm;
$this->title = '系统管理后台';
?>
<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>承兑汇票</h3>
                <small>承兑汇票系统管理后台 v1.0</small>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'method' => 'post'
                    ]);?>
                        <div class="form-group">
                            <label class="control-label" for="username">帐号</label>
                            <input type="text" placeholder="example | example@gmail.com" title="Please enter you username" name="username" value="<?=$loginName;?>" id="username" class="form-control input-sm">
                            <span class="help-block small">您的后台管理员帐号</span>
                        </div>
                        <div class="form-group <?php echo $message ? 'has-error' : '';?>">
                            <label class="control-label" for="password">密码</label>
                            <input type="password" title="Please enter your password" name="password" id="password" class="form-control input-sm">
                            <span class="help-block small"><?php echo $message ? $message : '您的登陆密码';?></span>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="save"> 记住登陆密码
                            </label>
                            <p class="help-block small">(为了管理安全,请不要在公共电脑下使用)</p>
                        </div>
                        <button class="btn btn-success btn-block btn-sm">Login</button>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            &copy; 承兑汇票 <?= date('Y') ?>
        </div>
    </div>
</div>
