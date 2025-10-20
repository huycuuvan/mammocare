<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\CatNews;
use backend\models\News;
use backend\models\Seo;
use backend\models\Product;
use yii\bootstrap\ActiveForm;
$seo = Seo::getSeo(Seo::GALLERY_PAGE);

if(empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = Yii::t('app', 'booking');
}


if (!empty($model->path))
    Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($model->path);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'thanks'), 'url' => ['site/thanks']];

?>
<section class="content my-5 checkroom">
    <div class="container">
        <?php if (Yii::$app->session->hasFlash('contact')): ?>
            <div class="alert alert-success" role="alert">
                <?= Yii::$app->session->getFlash('contact'); ?>
            </div>
        <?php endif ?>
    </div>
</section>