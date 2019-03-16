<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\ArticleCategory;
use app\models\Articles;

$this->title = $model->isNewRecord ? '添加案例' : '修改案例';
$this->params['breadcrumbs'][] = ['label' => '案例管理', 'url' => ['index']];
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
            'options' => ['enctype' => 'multipart/form-data', 'id'=>'postForm']
        ]); ?>
        <?= $form->field($model, 'category_id', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->dropDownList(ArrayHelper::merge([0=>'请选择分类'], Articles::$category), ['class'=>'form-control input-sm']); ?>
        <?= $form->field($model, 'name', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['maxlength' => true, 'class'=>'form-control input-sm']); ?>
        <?= $form->field($model, 'content')->widget(\crazydb\ueditor\UEditor::className(), ['config'=>['serverUrl' => ['/ueditor/index']]]) ?>

        <div class="form-group field-articles-name">
            <label class="control-label col-sm-2" for="articles-name">关联文章</label>
            <div class="col-sm-6">
                <?php if($articleList) : foreach ($articleList as $k => $v): ?>
                    <?php if($getIds) :?>
                        <input name="Articles[join][]" <?=in_array($k, $getIds) ? 'checked' : '';?> type="checkbox" value="<?=$k;?>" /><?=$v;?><br>
                    <?php else:?>
                        <input name="Articles[join][]" type="checkbox" value="<?=$k;?>" /><?=$v;?><br>
                    <?php endif;?>

                <?php  endforeach; endif;?>
                <p class="help-block help-block-error "></p>
            </div>
        </div>

        <?= $form->field($model, 'is_show', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->dropDownList(Articles::$showStates, (['class'=>'form-control input-sm']))?>
        <?= $form->field($model, 'sort', ['horizontalCssClasses' => ['wrapper' => 'col-sm-6']])->textInput(['class'=>'form-control input-sm'])->hint('排序值:越大越靠前') ?>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <?= Html::submitButton('保 存', ['class' => 'btn btn-primary btn-sm']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
