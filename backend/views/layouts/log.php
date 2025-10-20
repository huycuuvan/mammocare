<?php

/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\UrlManager;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
$base_tag = $_SERVER['SERVER_NAME']. (($_SERVER['SERVER_PORT'] != 80) ? (':'.$_SERVER['SERVER_PORT']):'').Yii::$app->urlManager->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <base href="//<?=$base_tag; ?>/" target="_self" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


    <?= $content ?>


<script>
    FontAwesomeConfig = { searchPseudoElements: true };
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
