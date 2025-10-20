<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\CatNews;
use backend\models\News;
use backend\models\Partner;
use yii\bootstrap\ActiveForm;

use yii\widgets\Breadcrumbs;
$this->title = ($model->name) ? $model->name : $model->name;
Yii::$app->params['og_description'] = ($model->name) ? $model->name : strip_tags($model->name);

if (!empty($model->path))
    Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($model->path);

$father = $model->father;

if (!empty($father->father)) {
    $this->params['breadcrumbs'][] = ['label' => $father->father->name, 'url' => ['site/list-doctor', 'id' => $father->father->id, 'name' => $father->father->url]];
}

$this->params['breadcrumbs'][] = ['label' => $father->name, 'url' => ['site/list-doctor', 'id' => $father->id, 'name' => $father->url]];
$this->params['overflow']='overflow-none';
?>
<section class="content news py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8  pl-lg-3 left order-lg-last">
                <div class="row pd10">
                    <div class="img-box col-12 col-md-5">
                        <img class="lazyload " data-src="<?= $model->path?$model->path:'upload/no-image.jpg'?>" alt="<?= $model->name ?>" title="<?= $model->name ?>" />
                    </div>
                    <div class="info-box mt-3 mt-md-0 col-12 col-md-7">
                        <h1 class="title mb-2 text-gradient"><?= $model->name; ?></h1>
                        <p class="specialist mb-1"><strong>Chuyên khoa: </strong><?=$model->father?$model->father->name:''?></p>
                        <p class="brief mb-2"><strong>Học vị: </strong><?=$model->brief?></p>
                        <a class="email mb-2 d-block" href="mailto:<?=$model->email?>"><strong>Email: </strong> <?=$model->email?></a>
                        <a class="phone mb-2 d-block" href="tel:<?=$model->mobile?>"><strong>Điện thoại:</strong> <?=$model->mobile?></a>
                        <div class="info1 mb-2">
                            <p class="mb-1 text-uppercase font-weight-bold text-gradient"><strong>Chứng chỉ</strong></p>
                            <div class="content-style"><?=$model->info1?></div>
                        </div>
                        <div class="info2 mb-2">
                            <p class="mb-1  text-uppercase font-weight-bold text-gradient"><strong>Kinh nghiệm</strong></p>
                            <div class="content-style"><?=$model->info2?></div>
                        </div>
<!--                        <div class="addthis_inline_share_toolbox_9ejr"></div>-->
                    </div>
                </div>
                <?php
                $relatedNews = $model->getRelated();
                if(!empty($relatedNews)){
                    ?>
                    <div class="news-latest mt-4">
                        <div class="text-uppercase font-weight-bold mb-3"><?=@$info['doctor-relate-title']?></div>
                        <div class="row list">
                            <?php
                            foreach ($relatedNews as $row){
                                $url = $row->getUrl();
                                ?>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-3 ">
                                    <div class="item-wrap">
                                        <div class="item text-center">
                                            <div class="img-box d-flex"  onclick="location.href='<?=$row->getUrl()?>';">
                                                <img class="lazyload img-cover" data-src="<?= $row->path?$row->path:'upload/no-image.jpg'?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" />
                                            </div>
                                            <div class="info-box mt-3 mb-2">
                                                <a class="name text-gradient mb-1 text-uppercase" href="<?=$row->getUrl()?>"><?=$row->name?></a>
                                                <p class="brief text-gradient mb-2"><?=$row->brief?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                            ?>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
            <?=Yii::$app->controller->renderPartial('pages/left')?>
        </div>
    </div>
</section>

