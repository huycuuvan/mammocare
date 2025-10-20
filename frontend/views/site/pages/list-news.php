<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Contact;
use backend\models\Partner;
use backend\models\Menu;
use backend\models\News;
use backend\models\CatNews;
use yii\widgets\Breadcrumbs;

$this->title = ($model->seo_title) ? $model->seo_title : $model->name;
Yii::$app->params['og_description'] = ($model->seo_desc) ? $model->seo_desc : $model->name;

$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => $model->getUrl()];
?>

<section class="content pt-4 py-lg-5  news">
	<div class="container">
        <div class="row">
            <div class="col-12 col-lg-8  pl-lg-3 left order-lg-last">
                <div class="list-news row pd8">
                    <?php
                    $i=0;
                    foreach ($news_list as $row) :
                        $cat_home=CatNews::findOne($row->cat_id);
                        $url = $row->getUrl();
                        $urlCat = $cat_home->getUrl();
                        ?>
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-3 ">
                            <div class="item">
                                <div class="img-box mb-0 mb-md-0">
                                    <div class="image_inner d-flex">
                                        <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->title ?>">
                                    </div>
                                </div>
                                <div class="item-body p-3">
                                    <div class="d-flex  cat-date mb-3 pb-3 border-bottom">
                                        <span class="date mb-0 mr-4"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($row->created_at)) ?></span>
                                        <a href="<?= $urlCat ?>" class=""><i class="fas fa-bars"></i> <?= $cat_home->name ?></a>
                                    </div>
                                    <h5 class="item-title mb-3">
                                        <a class="" href="<?= $url ?>"><?= $row->title ?></a>
                                    </h5>
                                    <p class="content mb-2 d-none"><?=myExt::getBlock(strip_tags($row->brief),190)?></p>
                                    <a class="more d-inline-block px-3" href="<?= $url ?>"><?= Yii::t('app','more1') ?> <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endforeach;
                    ?>

                    <div class="col-12">
                        <?= LinkPager::widget(['pagination' => $pagination,'prevPageLabel' => '« '.Yii::t('app', 'prev'),'nextPageLabel' => Yii::t('app', 'next').' »' ]) ?>
                    </div>

                </div>
            </div>
            <?=Yii::$app->controller->renderPartial('pages/left')?>
        </div>

	</div>
</section>
