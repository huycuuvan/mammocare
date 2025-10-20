<?php
use backend\models\Partner;
use backend\models\News;
use backend\models\Product;
use backend\models\Cat;
use backend\models\CatNews;
use backend\models\Video;
use frontend\models\SubscribeForm;
use yii\bootstrap\ActiveForm;

use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
$info = $this->params['info'];
$conf = $this->params['conf'];
?>
<div class="col-12 col-lg-4 mt-4 mt-lg-0 pl-lg-0 side-right slidebar">

    <div class="sidebar-fix123123">
        <?php
        $advRight = Partner::getPartner(Partner::ADS);
        if(!empty($advRight)){
            ?>
            <div class="adv-right">
                <?php
                $dem=0;
                foreach ($advRight as $row){?>
                    <a class="opacity d-block mb-3" href="<?=$row->url?>">
                        <img class="lazyload" data-src="<?=$row->path?>"  alt="<?=$row->name?>">
                    </a>
                    <?php
                    $dem++;
                }

                ?>
            </div>
            <?php
        }
        ?>

        <?php
        //If not in product page, show list cat
        $listCat = !empty($listCat) ? $listCat : CatNews::getCatNews();

        $catId = !empty($catId) ? $catId : 0;
        ?>

        <?php if ( !empty($listCat) ): ?>
            <div class="widget-box widget-category d-none">
                <h6 class="widget-title"><?= @$info['category-title'] ?></h6>

                <div class="list-box">
                    <ul>
                        <?php foreach ($listCat as $row) : ?>
                            <li class="<?= $row->id == $catId ? 'active' : '' ?>">
                                <a href="<?= $row->getUrl() ?>"><?= $row->name ?></a>

                                <?php $subCat = $row->getSubCat();
                                if (!empty($subCat)): ?>
                                    <ul>
                                        <?php foreach ($subCat as $child) : ?>
                                            <li class="<?= $child->id == $catId ? 'active' : '' ?>">
                                                <a href="<?= $child->getUrl() ?>"><?= $child->name ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php

        $all_cat=Cat::getParent();
        if(!empty($all_cat)){
            ?>
            <div class="widget-box cat-menu box-layer mb-3">
                <div class="widget-title"><?= @$info['category-product-title'] ?></div>
                <div class="list">
                    <ul>
                        <?php
                        $dem=0;
                        foreach ($all_cat as $row) {
                            $active=0;
                            $url = $row->getUrl();
                            $sub_cat = $row->getSubCat();
//                            if(!empty($sub_cat))
//                                foreach ($sub_cat as $row1){
//                                    if ($row1->id == $cat_id) $active++;
//                                }
                            ?>
                            <li class="<?php if($active>0) echo 'expand'; if($dem>0) echo ' border-top ' ;?>" >
                                <a class="d-block py-2 <?php /*if ($row->id == $cat_id) echo 'red';*/ ?>" href="<?= $url; ?>">
                                    <i class="fas fa-angle-double-right"></i> <?= $row->name; ?>
                                </a>
                                <?php

                                $name = $row->name;
                                if (!empty($sub_cat)) {
                                    ?>
                                    <i class="fa fa-angle-down"></i> <i class="fa fa-angle-up"></i>
                                    <ul class="pl-3 border-left">
                                        <?php foreach ($sub_cat as $row1) :
                                            $url = $row1->getUrl();
                                            ?>
                                            <li>
                                                <a class="d-block mb-2 <?php /*if ($row1->id == $cat_id) echo 'red'*/ ?>" href="<?= $url; ?>"><i class="fa fa-angle-right"></i> <?= $row1->name; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php

                                }
                                ?>
                            </li>
                            <?php
                            $dem++;
                        }
                        ?>

                    </ul>

                </div>
            </div>
            <?php
        }

        $five_product = Product::getHot();
        if(!empty($five_product)):
            ?>
            <div class="widget-box widget-category news-latest">
                <h6 class="widget-title"><?= @$info['product-title-right'] ?></h6>

                <div class="list-news-latest">
                    <?php foreach ($five_product as $row) :
                        $url = $row->getUrl();
                        ?>
                        <div class="item-article clearfix">
                            <div class="post-image">
                                <a href="<?= $url; ?>" class="d-flex"><img class="img-cover" src="<?= $row->path ?>" alt="<?=$row->name; ?>"></a>
                            </div>
                            <div class="post-content">
                                <div class="title"><a href="<?= $url; ?>"><?=$row->name; ?></a></div>
                                <div class="date d-none">
                                    <?= myExt::formatPrice($row->sale)?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif;

        $five_hits_news=News::getLatestFive();
        if(!empty($five_hits_news)){
            ?>
            <div class="widget-box widget-category news-latest">
                <h6 class="widget-title"><?= @$info['news-title-right'] ?></h6>

                <div class="list-news-latest">
                    <?php foreach ($five_hits_news as $row) :
                        $url = $row->getUrl();
                        $catUrl = $row->father->getUrl();
                        ?>
                        <div class="item-article clearfix">
                            <div class="post-image">
                                <a href="<?= $url; ?>"><img class="lazyload" data-src="<?= $row->path ?>" alt="<?=$row->title; ?>"></a>
                            </div>
                            <div class="post-content">
                                <div class="title"><a href="<?= $url; ?>"><?=$row->title; ?></a></div>
                                <div class="date">
                                    <i class="fa fa-calendar-alt"></i> <?=date('d/m/Y',strtotime($row->created_at))?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }


        $video_list = Video::getHomeVideo();
        if(!empty($video_list)){

            ?>
            <div class="widget-box widget-category d-none">
                <h6 class="widget-title"><?= Yii::t('app', 'video') ?></h6>

                <div class="list-video">
                    <div class="owl-carousel owl-theme owl-slider-video">
                        <?php foreach ($video_list as $row) : ?>
                            <div class="item-video">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $row->code ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>


        <?php
        $model = new SubscribeForm;
        $model->scenario = SubscribeForm::SCENARIO_REGISTER;
        ?>

        <div class="widget-box widget-category formbox d-none">
            <h6 class="widget-title"><?= @$info['request-title'] ?></h6>

            <div class="form-body">
                <?php $form = ActiveForm::begin(['action' => Url::toRoute('site/subscribe'), 'id' => 'subscribe-form', 'enableClientScript' => false, 'enableClientValidation' => false]); ?>

                <?= $form->field($model, 'name')->textInput(['placeholder' => Yii::t('app', 'fullname')])->label(false) ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('app', 'email')])->label(false) ?>

                <?= $form->field($model, 'phone')->textInput(['placeholder' => Yii::t('app', 'phone')])->label(false) ?>

                <?= $form->field($model, 'body')->textInput(['placeholder' => Yii::t('app', 'message')])->label(false) ?>

                <?= $form->field($model, 'type')->hiddenInput(['value' => SubscribeForm::SCENARIO_REGISTER])->label(false) ?>

                <div class="form-footer">
                    <?= Html::submitButton(Yii::t('app', 'submit'), ['class' => 'btn btn-submit']) ?>
                </div>

                <div class="network_social">
                    <?= Html::a('<i class="fab fa-facebook-f"></i>', $conf->facebook_url, array('target'=>'_blank','class'=>'facebook_icon'));?>
                    <?= Html::a('<i class="fab fa-youtube"></i>', $conf->youtube_url, array('target'=>'_blank','class'=>'youtube'));?>
                    <?= Html::a('<i class="fab fa-twitter"></i>', $conf->twitter_url, array('target'=>'_blank','class'=>'twitter_url'));?>
                </div>


                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php
        $five_product=Product::getHot();
        if(false && !empty($five_product)){
            ?>
            <div class="news-latest box-layer mb-3">
                <div class="sidebarblog-title title_block"><?= @$info['product-title-right'] ?></div>
                <div class="list-news-latest">
                    <?php foreach ($five_product as $row) :
                        $url = $row->getUrl();
                        ?>
                        <div class="item-article clearfix">
                            <div class="post-image center">
                                <a class=" d-flex" href="<?= $url; ?>"><img class="m-auto lazyload" data-src="<?= $row->path ?>" alt="<?=$row->name; ?>"></a>
                            </div>
                            <div class="post-content">
                                <div class="title"><a href="<?= $url; ?>"><?=$row->name; ?></a></div>
                                <div class="price-more d-flex mb-0  align-items-center">
                                    <span class="price mr-3"><strong><?= myExt::formatPrice($row->sale)?></strong></span>
                                    <?php if($row->retail){?><span class="retail "><?= myExt::formatPrice($row->retail)?></span> <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
        ?>


    </div>
</div>