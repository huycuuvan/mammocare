<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Hosting;
use yii\bootstrap\ActiveForm;
use backend\models\Seo;
use backend\models\Partner;
use yii\widgets\Breadcrumbs;

$seo = Seo::getSeo(Seo::GALLERY_PAGE);

if(!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = 'Gallery';
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'gallery'), 'url' => ['gallery','page'=>1]];
?>
<section class="content gallery py-4 bg_grey">
    <div class="container">
        <div class="row">
            <?php 
            if(!empty($model)) {
                foreach ($model as $row): ?>
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        <div class="shadow">
                            <a href="<?= $row->getUrl() ?>" class="d-block photo-item">
                                <img src="<?= $row->getFullImg() ?>" alt="<?= $row->name; ?>" class="img-fluid">
                            </a>
                            <div class="photo-text-more p-3">
                                <h3 class="heading montserrat"><?= $row->name; ?></h3>
                                <span class="meta"><?= $row->countPicture() ?> Ảnh</span>
                            </div>
                        </div>

                    </div>
                <?php endforeach;
                LinkPager::widget(['pagination' => $pagination,'prevPageLabel' => '« '.Yii::t('app', 'prev'),'nextPageLabel' => Yii::t('app', 'next').' »' ]);
            }
            ?>
        </div>

    </div>
</section>