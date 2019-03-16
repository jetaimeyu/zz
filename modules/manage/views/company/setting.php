<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Area;
use \yii\helpers\Url;

$this->title = '资料设置';
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
            ],
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($model, 'name')->staticControl(); ?>
        <?= $form->field($model, 'slogan', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm', 'placeholder'=>'提供服务']); ?>
        <?= $form->field($model, 'description', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textArea(['maxlength' => true, 'class'=>'form-control input-sm', 'style'=>'height:300px;', 'placeholder'=>'']); ?>

        <?= $form->field($model, 'imageUpload', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->fileInput(['maxlength' => true, 'class'=>'form-control input-sm'])->hint('建议上传尺寸: 企业展示900X250');?>
        <?php if($model->image):?>
            <?= $form->field($model, 'image', ['inputTemplate'=>'<img src="'.$model->imageUrl.'" height="80" />'])->staticControl() ?>
        <?php endif;?>

        <?= $form->field($model, 'describeImageUpload', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->fileInput(['maxlength' => true, 'class'=>'form-control input-sm'])->hint('建议上传尺寸: 企业展示550X550');?>
        <?php if($model->describe_image):?>
            <?= $form->field($model, 'describe_image', ['inputTemplate'=>'<img src="'.$model->describeImageUrl.'" height="80" />'])->staticControl() ?>
        <?php endif;?>

        <div></div>

        <div class="form-group field-supplier-sort <?php if($model->getErrors('province_id') || $model->getErrors('city_id') || $model->getErrors('district_id')):?>has-error<?php else:?>has-success<?php endif;?>">
            <label class="control-label col-sm-2" for="supplier-sort">省份城市</label>
            <div class="col-sm-10">
                <div class="form-inline">
                    <?=Html::activeDropDownList($model, 'province_id', ArrayHelper::merge([0=>'请选择省份'], Area::getArrayForInput(1)), ['class'=>'input-sm form-control', 'tabindex'=>5]);?>
                    <?=Html::activeDropDownList($model, 'city_id', ArrayHelper::merge([0=>'请选择城市'], Area::getArrayForInput($model->province_id)), ['class'=>'input-sm form-control', 'tabindex'=>5])?>
                    <?=Html::activeDropDownList($model, 'district_id', ArrayHelper::merge([0=>'请选择区域'], Area::getArrayForInput($model->city_id)), ['class'=>'input-sm form-control', 'tabindex'=>5])?>
                </div>
                <div class="help-block help-block-error "><?=$model->getFirstError('province_id') . $model->getFirstError('city_id') . $model->getFirstError('district_id')?></div>
            </div>
        </div>
        <?= $form->field($model, 'address', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm']); ?>
        <?= $form->field($model, 'mobile', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm', 'placeholder'=>'联系手机：18688888888，不显示则留空']); ?>
        <?= $form->field($model, 'email', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm', 'placeholder'=>'联系邮箱：test@test.com，不显示则留空']); ?>
        <?= $form->field($model, 'weixin', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm', 'placeholder'=>'联系微信号，不显示则留空']); ?>
        <?= $form->field($model, 'qq', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm', 'placeholder'=>'联系QQ号，不显示则留空']); ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <?= Html::submitButton('修改', ['class' => 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#company-province_id').change(function(){
            var parent_id = parseInt($(this).val());
            $.post('<?=Url::to(['/ajax/areaoption'])?>', {parent_id:parent_id, d:'请选择城市'}, function(data){
                if(data) {
                    $('#company-city_id').html(data);
                    $('#company-district_id').html('<option>请选择区域</option>');
                }
            });
        });
        $('#company-city_id').change(function(){
            var parent_id = parseInt($(this).val());
            $.post('<?=Url::to(['/ajax/areaoption'])?>', {parent_id:parent_id, d:'请选择区域'}, function(data){
                if(data) {
                    $('#company-district_id').html(data);
                }
            });
        });
    });
</script>