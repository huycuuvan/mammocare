<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
use backend\models\Seo;
use backend\models\Contact;
//use yii\widgets\LinkPager;
use justinvoelker\separatedpager\LinkPager;

$seo = Seo::getSeo(Seo::VIDEO_PAGE);

if(empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = Yii::t('app', 'video');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'video'), 'url' => ['site/video','page'=>1]];
?>
<div class="content py-4 py-lg-5 video-page">
    <div class="container">
        <div class="row">
            <?php foreach ($model as $row): ?>
                <div class="col-12 col-sm-6 col-lg-4 mb-4 pb-2">
                    <div class="item-video">
                        <div class="img-box">
                            <a href="https://www.youtube.com/watch?v=<?= $row->code ?>" title="<?= $row->name; ?>" data-fancybox>
                                <img src="https://img.youtube.com/vi/<?= $row->code ?>/sddefault.jpg" alt="<?= $row->name ?>" />
                            </a>

                        </div>
                        <h3 class="title mt-3 px-3 mb-lg-3 text-center">
                            <a href="https://www.youtube.com/watch?v=<?= $row->code ?>"><?= $row->name; ?></a>
                        </h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="">
            <?= LinkPager::widget(['pagination' => $pagination,'maxButtonCount' => 6,
                'prevPageLabel' => '«',
                'nextPageLabel' => '»',
                'prevPageCssClass' => 'prev hidden-xs',
                'nextPageCssClass' => 'next hidden-xs',
                'activePageAsLink' => false, ]) ?>
        </div>
    </div>

</div>
