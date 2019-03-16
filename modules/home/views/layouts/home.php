<?php
use yii\helpers\Html;
use app\assets\HomeAsset;

HomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="keywords" content="济南承兑汇票贴现，济南电子承兑汇票贴现，济南银行承兑汇票贴现" />
    <meta name="description" content="【网站出租】济南承兑汇票网:银行承兑汇票贴现,商业承兑汇票贴现,电子商业承兑汇票贴现，国内国际备用信用证贴现,济南承兑汇票网一家专业从事银行承兑汇票贴现的公司。" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="page">
        <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
