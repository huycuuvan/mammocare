<?php
use backend\models\Partner;
use backend\models\News;
use backend\models\CatNews;
use backend\models\Menu;
use backend\models\Cat;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
$info = $this->params['info'];
$conf= $this->params['conf'];
$menu_id=0;
$menu_active=0;
if(isset($this->params['menu-id'])) $menu_id=$this->params['menu-id'];
if(isset($this->params['menu-active'])) $menu_active=$this->params['menu-active'];
//var_dump($menu_active);
$menu=Menu::findOne($menu_id);
$check_menu=false;
if(!empty($menu)){
    $subMenu = $menu->getSubMenu();
    if(!empty($subMenu)) $check_menu=true;
}
?>
<div class="col-12 col-lg-4 mt-4 mt-lg-0 pl-lg-0 side-right slidebar">
    <?php
    //nếu k có menu con thì hiển thị danh sách tin
    if($check_menu==false){
        $all_cat=CatNews::getParent();
        if(!empty($all_cat)){
            ?>
            <div class="widget-box widget-category mb-3">
                <div class="widget-title-wrap">
                    <div class="widget-title"><?= @$info['category-news-title'] ?></div>
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
                                    <span class="pl-1">(<?=CatNews::countNews($row->id)?>)</span>
                                </div>

                                <?php

                                $name = $row->name;
                                if (!empty($sub_cat)) {
                                    $t=0;
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
                                                    <span class="pl-1">(<?=CatNews::countNews($row1->id)?>)</span>
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
    }
    else{
        //nếu có menu con thì hiển thị theo menu
        if(!empty($subMenu)){
            ?>
            <div class="widget-box widget-category mb-3">
                <div class="widget-title-wrap">
                    <div class="widget-title"><?= $menu->name ?></div>
                </div>

                <div class="list-box">
                    <ul>
                        <?php
                        $dem=0;
                        foreach ($subMenu as $row) {
                            $active=0;
                            $url = $row->link;
                            $sub_cat = $row->getSubMenu();
                            ?>
                            <li class="<?php if($active>0) echo 'expand'; ?>" >
                                <div class="<?= $dem>0?'pt-2 mt-2 border-top':'' ?> d-flex align-items-center justify-content-between">
                                    <a href="<?= $url; ?>" class="<?=$menu_active==$row->id?'active':''?>">
                                        <i class="fas fa-caret-right"></i> <?= $row->name; ?>
                                    </a>
                                    <?php
                                    if(!empty($sub_cat)){
                                    ?>
                                    <span class="pl-1"><i class="fas fa-angle-double-right"></i></span>
                                        <?php
                                    }
                                        ?>
                                </div>

                                <?php

                                $name = $row->name;
                                if (!empty($sub_cat)) {
                                    $t=0;
                                    ?>
                                    <!--                                <i class="fa fa-angle-down"></i> <i class="fa fa-angle-up"></i>-->
                                    <ul class="pl-3 pt-2">
                                        <?php foreach ($sub_cat as $row1) :
                                            $url = $row1->link;
                                            ?>
                                            <li>
                                                <div class="<?=$t>0?'mt-2 pt-2 border-top':''?> d-flex align-items-center justify-content-between">
                                                    <a href="<?= $url; ?>">
                                                        <i class="fas fa-caret-right"></i> <?= $row1->name; ?>
                                                    </a>
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
    }


    $five_hits_news=News::getLatestFive();
    if(!empty($five_hits_news)){
        ?>
        <div class="widget-box widget-news news-latest">
            <div class="widget-title"><?= @$info['news-title-right'] ?></div>

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