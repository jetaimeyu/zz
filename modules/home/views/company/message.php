<?php
$this->title = '联系我们';
use yii\bootstrap\ActiveForm;
use app\widget\TopWidget;
use app\widget\FooterWidget;
use yii\helpers\Html;
use yii\captcha\Captcha;
?>
<link rel="stylesheet" href="<?=Yii::getAlias('@resUrl/css/bootstrap.min.css')?>">
<?=TopWidget::widget(['company' => $company]);?>
<div class="page-body">
    <div style="height: 30px;"></div>
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
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'title', ['horizontalCssClasses' => ['wrapper' => 'col-sm-4']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm']) ?>
    <?= $form->field($model, 'name', ['horizontalCssClasses' => ['wrapper' => 'col-sm-4']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm']); ?>
    <?= $form->field($model, 'email', ['horizontalCssClasses' => ['wrapper' => 'col-sm-4']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm']) ?>
    <?= $form->field($model, 'mobile', ['horizontalCssClasses' => ['wrapper' => 'col-sm-4']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm']) ?>
    <?= $form->field($model, 'content', ['horizontalCssClasses' => ['wrapper' => 'col-sm-5']])->textarea(['class'=> "form-control", 'rows' => "3"]); ?>

    <div class="form-group">
        <label class="control-label col-sm-2">验证码</label>
        <div class="col-sm-3 fl">
            <input type="text" class="form-control input-sm" name="LeaveMessage[verifyCode]" maxlength="255" aria-required="true">
            <p class="help-block help-block-error "></p>
        </div>
        <div class="add-code fl">
            <?=Captcha::widget([
                'name' => 'verifyCode',
                'captchaAction' => '/site/captcha',
                'template' => '{image}',
                'options' => ['id' => 'input'],
                'imageOptions' => ['alt' => '点击刷新验证码'],
            ])?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-6">
            <?= Html::submitButton('提交' , ['class' => 'btn btn-success btn-sm']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

<?=FooterWidget::widget(['company' => $company, 'link' => $link,]);?>
</div>
<script>

    var checkSubmitFlg = false;

    function checkSubmit(){

        if(checkSubmitFlg ==true){
            return false; //当表单被提交过一次后checkSubmitFlg将变为true,根据判断将无法进行提交。
        }

        checkSubmitFlg =true;

        return true;

    }

</script>
