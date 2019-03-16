<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '修改密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-body">
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
            ]
        ]); ?>
        <div class="form-group field-manager-name">
            <label class="control-label col-sm-2">原密码</label>
            <div class="col-sm-3">
                <input type="password" class="form-control input-sm" name="oldPassword" value="" maxlength="255">
                <div class="help-block help-block-error "></div>
            </div>
        </div>
        <div class="form-group field-manager-name" id="newPassword">
            <label class="control-label col-sm-2">新密码</label>
            <div class="col-sm-3">
                <input type="password" class="form-control input-sm" name="password" value="" maxlength="255">
                <div class="help-block help-block-error" id="errorMessage"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <?= Html::submitButton('修改', ['class' => 'btn btn-primary btn-sm']) ?>
                <div class="help-block"><?=$message;?></div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    document.body.onload = function() {
        $('form').submit(function(){
            var password = $('input[name="password"]').val();
            if(!password) {
                $('#newPassword').addClass('has-error');
                $('#errorMessage').html('新密码不能为空');
                return false;
            }
            return true;
        });
    };
</script>
