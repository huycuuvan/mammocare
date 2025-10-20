<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Contact;
use backend\models\Partner;
use backend\models\Menu;
use backend\models\News;
use backend\models\CatDoctor;
use yii\widgets\Breadcrumbs;

$this->title = ($model->seo_title) ? $model->seo_title : $model->name;
Yii::$app->params['og_description'] = ($model->seo_desc) ? $model->seo_desc : $model->name;

$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => $model->getUrl()];
?>

<section class="content pt-4 py-lg-5  list-doctor news">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8  pl-lg-3 left order-lg-last">
                <div class="tab-link mb-4   ">
                    <ul class="nav nav-tabs d-inline-flex align-items-center mx-auto" id="myTabProducts" role="tablist" >
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-content-nav" data-toggle="tab" href="#tab-content" role="tab" aria-controls="home" aria-selected="true"><?= @$info['tab-content'] ?></a>
                        </li>
                    <li class="nav-item ml-2">
                            <a class="nav-link" id="tab-doctor-nav" data-toggle="tab" href="#tab-doctor" role="tab" aria-controls="home" aria-selected="true"><?= @$info['tab-doctor'] ?></a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-content" role="tabpanel" aria-labelledby="tab-content">
                        <h1 class="title mb-4"><?= $model->name; ?></h1>
                        <div class="content-style mucluc" data-text="<?=Yii::t('app','mucluc')?>">
                            <div class="offset-content">
                                <?= MyExt::changeContents($model->content); ?>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade " id="tab-doctor" role="tabpanel" aria-labelledby="tab-doctor">
                        <div class="list-news row pd8">
                            <?php
                            $i=0;
                            foreach ($doctor_list as $row) :
                                $url = $row->getUrl();
                                ?>
                                <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-3 ">
                                    <div class="item-wrap">
                                        <div class="item text-center">
                                            <div class="img-box d-flex"  onclick="location.href='<?=$row->getUrl()?>';">
                                                <img class="lazyload img-cover" data-src="<?= $row->path?$row->path:'upload/no-image.jpg'?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" />
                                            </div>
                                            <div class="info-box mt-3 mb-3">
                                                <a class="name text-gradient mb-1 text-uppercase" href="<?=$row->getUrl()?>"><?=$row->name?></a>
                                                <p class="brief text-gradient mb-2"><?=$row->brief?></p>
                                                <p class="info mb-2 "><?=$row->content?></p>
                                                <a class="email d-block" href="mailto:<?=$row->email?>"><i class="far fa-envelope"></i> <?=$row->email?></a>
                                                <a class="phone" href="tel:<?=$row->mobile?>"><i class="fas fa-phone-alt"></i> <?=$row->mobile?></a>
                                            </div>
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
                </div>
            </div>
            <?=Yii::$app->controller->renderPartial('pages/left')?>
        </div>

    </div>
</section>
