<?php
use backend\models\Partner;
use backend\models\News;
use backend\models\CatNews;
use backend\models\Product;
use backend\models\Cat;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
$info = $this->params['info'];
$conf= $this->params['conf'];
?>
<div class="col-12 col-lg-4 mt-4 mt-lg-0 pl-lg-0 side-right slidebar">
    <?php
    $all_cat=Cat::getParent();
    if(!empty($all_cat)){
        ?>
        <div class="widget-box widget-category mb-3">
            <div class="widget-title-wrap">
                <div class="widget-title"><?= @$info['category-product-title'] ?></div>
            </div>

            <div class="list-box">
                <ul>
                    <?php
                    $dem=0;
                    foreach ($all_cat as $row) {
                        $active=0;
                        $url = $row->getUrl();
                        $sub_cat = $row->getSubCat();
                        ?>
                        <li class="<?php if($active>0) echo 'expand'; ?>" >
                            <div class="<?= $dem>0?'pt-2 mt-2 border-top':'' ?> d-flex align-items-center justify-content-between">
                                <a href="<?= $url; ?>">
                                    <i class="fas fa-angle-double-right"></i> <?= $row->name; ?>
                                </a>
                                <span class="pl-1">(<?=$row->getCount()?>)</span>
                            </div>

                            <?php

                            $name = $row->name;
                            $t=0;
                            if (!empty($sub_cat)) {
                                ?>
<!--                                <i class="fa fa-angle-down"></i> <i class="fa fa-angle-up"></i>-->
                                <ul class="pl-3 pt-2">
                                    <?php foreach ($sub_cat as $row1) :
                                        $url = $row1->getUrl();
                                        ?>
                                        <li>
                                            <div class="<?=$t>0?'mt-2 pt-2 border-top':''?> d-flex align-items-center justify-content-between">
                                                <a href="<?= $url; ?>">
                                                    <i class="fas fa-caret-right"></i> <?= $row1->name; ?>
                                                </a>
                                                <span class="pl-1">(<?=$row1->getCount()?>)</span>
                                            </div>
                                        </li>
                                    <?php
                                    $t++;
                                    endforeach; ?>
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



    $five_product=Product::getHot();
    if(!empty($five_product)){
        ?>
        <div class="widget-box widget-news news-latest">
            <h6 class="widget-title"><?= @$info['product-title-right'] ?></h6>

            <div class="list-news-latest">
                <?php foreach ($five_product as $row) :
                    $url = $row->getUrl();
                    ?>
                    <div class="item-article clearfix">
                        <div class="post-image ">
                            <a class=" href="<?= $url; ?>"><img class=" lazyload" data-src="<?= $row->path ?>" alt="<?=$row->name; ?>"></a>
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
    <div class="widget-box widget-social mb-3">
        <div class="widget-title"><?= @$info['social-title'] ?></div>
        <div class="network-social">
            <div class="d-flex align-items-center">
                <?= Html::a('<i class="fab fa-facebook-f"></i>', $conf->facebook_url, array('target'=>'_blank','class'=>'facebook_icon rounded mr-2 mr-xl-3'));?>
                <?= Html::a('<i class="fab fa-youtube"></i>', $conf->youtube_url, array('target'=>'_blank','class'=>'youtube rounded mr-2 mr-xl-3'));?>
                <?= Html::a('<i class="fab fa-twitter"></i>', $conf->twitter_url, array('target'=>'_blank','class'=>'twitter_url rounded'));?>
            </div>
        </div>
    </div>
    <div class="fixed-mucluc d-none">
        <i class="fas fa-list-ol"></i>
    </div>
    <div class="er_toc  er_toc_fixed d-none"></div>
</div>