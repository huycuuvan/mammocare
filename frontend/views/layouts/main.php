<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use backend\models\Contact;
use backend\models\Configure;
use backend\models\Menu;
use backend\models\Tab;
use backend\models\Album;
use backend\models\Partner;
use backend\models\Cat;
use backend\models\Video;
use backend\models\Language;
use backend\models\Supporter;
use yii\bootstrap\ActiveForm;
use backend\components\MyExt;
use frontend\models\ShopCart;
use frontend\models\HostingCart;
use frontend\models\SubscribeForm;
AppAsset::register($this);
$cont = $this->params['cont'];
$conf = $this->params['conf'];
$info = $this->params['info'];
//Metatags register
\Yii::$app->view->registerMetaTag(['name' => 'og:locale', 'content' => $this->params['lang']->iso_code]);
\Yii::$app->view->registerMetaTag(['name' => 'og:site_name', 'content' => $cont->site_title]);
\Yii::$app->view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->request->absoluteUrl]);
\Yii::$app->view->registerMetaTag(['name' => 'og:image', 'content' => Yii::$app->params['og_image']]);
\Yii::$app->view->registerMetaTag(['name' => 'og:title', 'content' => $this->title]);
\Yii::$app->view->registerMetaTag(['name' => 'og:description', 'content' => Yii::$app->params['og_description']]);
\Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['og_description']]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= $conf->head_tag ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- <base href="<?=Url::base(true) ?>/" target="_self" /> -->
    <?php
    $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => $conf->favicon]);
    $this->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->params['canonical']]);
    ?>
    <?php $this->head() ?>
    <?=$conf->closed_head_tag?>
</head>
<body class="<?=MyExt::mobileDetect()?'mobile':''?>">
<?php $this->beginBody() ?>
<div>
    <header class="<?= MyExt::mobileDetect()?'fixed-mobile':'' ?>">
        <?php
        $menuList = Menu::getMenu(Menu::MAIN_MENU);
        $menuTop = Menu::getMenu(Menu::TOP_MENU);
        $cart = \Yii::$app->cart;
        // $count_cart = $cart->getTotalCount();
        $count_cart=0;
        $menu_id=0;
        $languageList = Language::getLanguage();
        if(isset($this->params['menu-id'])) $menu_id=$this->params['menu-id'];
        ?>
        <?php if (!MyExt::mobileDetect()) { ?>
            <div class="top-bar d-none d-md-block">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="top-left">
                            <div class="item network_social">
                                <div class="d-flex align-items-center">
                                    <span class="mr-2"><?=@$info['social-title']?>: </span>
                                    <?= Html::a('<i class="fab fa-facebook-f"></i>', $conf->facebook_url, array('target'=>'_blank','class'=>'facebook_icon rounded mr-2 mr-xl-3'));?>
                                    <?= Html::a('<i class="fab fa-youtube"></i>', $conf->youtube_url, array('target'=>'_blank','class'=>'youtube rounded mr-2 mr-xl-3'));?>
                                    <?= Html::a('<i class="fab fa-twitter"></i>', $conf->twitter_url, array('target'=>'_blank','class'=>'twitter_url rounded'));?>
                                </div>
                            </div>
                        </div>
                        <div class="top-right text-right">
                            <span class="time ">
                                <i class="fas fa-clock"></i> <?=@$info['time-work']?>
                            </span>
                            <?= Html::a('<i class="fas fa-phone-alt mr-2"></i> <strong class="mr-2">Hotline: </strong>'.@$cont->hotline, 'tel:'.@$cont->hotline, array('class'=>'has-border'));?>
                            <?= Html::a('<i class="far fa-envelope mr-2"></i>  <strong class="mr-2">Email: </strong>'.@$cont->email, 'mailto:'.@$cont->email, array('class'=>'has-border'));?>
                            <?php
                            if(!empty($menuTop)){
                                foreach ($menuTop as $row){
                                    ?>
                                    <a class="has-border" href="<?= $row->link ?>"><?= $row->name ?></a>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            if(count($languageList)>1){
                                ?>
                                <div class="lang-vina d-inline-block ml-2 ml-xl-3">
                                    <?php
                                    foreach ($languageList as $lang): ?>
                                        <a href="<?= Url::toRoute(['site/change-lang', 'code' => $lang->code]) ?>" class='ml-2'>
                                            <img src="<?= $lang->path ?>" alt="<?= $lang->name ?>" />
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col text-right d-none">
                            <div class="network_social d-inline mr-3">
                                <?php Html::a('<i class="fas fa-headset"></i>'.Yii::t('app','tutorial'), $conf->twitter_url, array('target'=>'_blank','class'=>'facebook_icon mr-3'));?>
                                <?php
                                foreach($menuTop as $item){
                                    ?>
                                    <?= Html::a($item->name, $item->link, array('target'=>'_blank','class'=>'facebook_icon mr-1'));?>
                                <?php } ?>
                                <a href="#" class="open-search bt-hotline search facebook_icon"><i class="fas fa-search"></i> <?= Yii::t('app','search') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="logo-menu-lang">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo-group-box">
                            <div class="logo-group">
                                <a href="<?= Url::home(true) ?>" title="<?= $this->title ?> lg" class="d-flex  logo">
                                    <img class="m-auto img-contain" src="<?= $cont->logo ?>" alt="<?= $this->title ?> fix" />
                                </a>
                            </div>
                        </div>
                        <div class="menu-cart ">
                            <div class="menubar d-flex justify-content-center align-items-center">
                                <nav class="navbar navbar-expand-md" id="narbarMainMenu">
                                    <div class="navbar-collapse collapse">
                                        <ul class="navbar-nav navbar-menu w-100">
                                            <?php foreach ($menuList as $row) :
                                                $subMenu = $row->getSubMenu();
                                                ?>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase <?=$menu_id==$row->id?'active':''?> <?= !empty($subMenu)?'has-sub':'' ?>" href="<?= $row->link ?>">
                                                        <?= $row->name ?>
                                                    </a>
                                                    <?php if (!empty($subMenu)) :
                                                        echo "<ul>";
                                                        $j = 0;
                                                        foreach ($subMenu as $mnc) :
                                                            $mnchild1 = $mnc->getSubMenu();
                                                            echo "<li>" . Html::a($mnc->name, $mnc->link);
                                                            if (!empty($mnchild1)) {
                                                                echo '<ul>';
                                                                foreach ($mnchild1 as $mnc1) {
                                                                    echo "<li>" . Html::a('<i class="fas fa-angle-right"></i> ' . $mnc1->name, $mnc1->link);
                                                                    echo "</li>";
                                                                }
                                                                echo '</ul>';
                                                            }
                                                            echo "</li>";
                                                            $j++;
                                                        endforeach;
                                                        echo "</ul>";
                                                    endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="menu-right d-flex align-items-center justify-content-end">
                            <div class="d-flex align-items-center">
                                <div class="search_desktop_button mr-3">
                                    <i class="ri-search-2-line"></i>
                                    <i class="fas fa-times" style="display: none;"></i>
                                </div>
                                <div class="hotline d-flex1 d-none align-items-center">
                                    <i class="fas fa-phone-alt mr-2"></i>
                                    <div class="text">
                                        <p class="mb-1">Hotline</p>
                                        <a href="tel:<?=$cont->hotline?>"><?=$cont->hotline?></a>
                                    </div>
                                </div>
                                <div class="hotline d-flex flex-column">
                                    <a class="more-button d-inline-block pl-2 pr-3 px-md-41 " href="tel:<?= $cont->hotline; ?>">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-phone mr-2"></i>
                                            <span>
                                                Hotline<br><?= $cont->hotline; ?>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="wrap-cart d-none">
                                <a href="<?= Url::to(['site/shopping-order']); ?>" class="cart_menu  mr-3 d-flex align-items-center">
                                    <span class="d-none"><i><?= $count_cart; ?></i><img src="bundle/css/images/shopping-cart.png" alt="gio hang yeu thich"></span>
                                    <span class="icon mr-1"><i class="pos"><?= $count_cart; ?></i><i class="fas fa-shopping-basket"></i></span>
                                    <span class="text"><?=Yii::t('app','shopping-cart')?></span>
                                </a>
                                <div class="show-cart show-cart-header show-shop-cart">
                                    <div class="wrap">
                                        <div class="title"><i class="fas fa-shopping-basket"></i> <?= Yii::t('app', 'cart-result', ['count' => '<span>' . $count_cart . '</span>']) ?></div>
                                        <?php
                                        $all_total=0;
                                        if(!empty($cart->getItems())){
                                            $dem=0;
                                            foreach ($cart->getItems() as $row) :
                                                $product = $row->getProduct();
                                                ?>
                                                <div class="_record d-flex d-flex justify-content-between px-3 mb-3  <?php if($dem==0) echo 'mt-3' ?> ">
                                                    <a href="<?= $product->getUrl() ?>" class="img-box d-flex mt-1">
                                                        <img class="m-auto" src="<?= $product->getDefaultImg()  ?>" alt="<?= $product->name ?>" title="<?= $product->name ?>" />
                                                    </a>
                                                    <div class="pl-3">
                                                        <a class="product-name d-block mb-0" href="<?= $product->getUrl(); ?>"><?= $product->name; ?></a>
                                                        <p class="mb-0">
                                                            <?= $row->getQuantity() ?> x <span class="price"><?= MyExt::formatPrice($row->getPrice()) ?></span>
                                                            <a href="<?=Url::to(['site/removecart','id'=>$product->id])?>"><i class="far fa-trash-alt"></i></a>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php
                                                $dem++;
                                            endforeach;
                                        }
                                        else{?>
                                            <div class="content" id="cart-list">
                                                <div class="mess-none-cart">
                                                    <?= Yii::t('app', 'shopping-cart-empty') ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if(!empty($cart->getItems())){
                                        ?>
                                        <div class="">
                                            <p class="total px-3 py-2 mb-0 border-top text-center font-weight-bold"><?=Yii::t('app', 'shopping-total')?>: <span class="red"><?= MyExt::formatPrice($cart->getTotalCost()) ?></span> </p>
                                            <a href="<?= Url::toRoute('shopping-order') ?>" class="btn d-block btn-danger border-0 text-uppercase">
                                                <?= Yii::t('app', 'shopping-cart') ?>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php if (count($languageList) > 1): ?>
                                <div class="lang-box d-none align-items-center text-center">
                                    <div class="dropdown ">
                                        <div class="dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="tit d-block mb-0"><?= Yii::t('app','language') ?></span>
                                            <span class="language big text-uppercase">
                                        <?php
                                        foreach ($languageList as $lang):
                                            if (Yii::$app->language == $lang->code) { ?>
                                                <?=$lang->code?>
                                                <?php
                                            }
                                        endforeach; ?>
                                    </span>
                                        </div>
                                        <div class="dropdown-menu language" aria-labelledby="dropdownMenuButton">
                                            <?php
                                            foreach ($languageList as $lang):
                                                ?>
                                                <a class="dropdown-item text-uppercase" href="<?= Url::toRoute(['site/change-lang', 'code' => $lang->code]) ?>">
                                                    <img src="<?= $lang->path ?>" alt="<?= $lang->name ?>"/>
                                                </a>
                                            <?php
                                            endforeach; ?>
                                        </div>
                                    </div>
                                    <span class="before"></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search_desktop_wrap">
                <div class="container">
                    <div class="search_desktop search_mobile">
                        <?php echo Html::beginForm(['site/search-news'], 'GET', ['class' => 'search_form d-flex']); ?>
                        <input type="text" class="txtkeyword search_keyword" name="keyword"
                               placeholder="<?=@$info['search-text']?>" autocomplete="off">
                        <button type="submit"><span><i class="fa fa-search"></i></span></button>
                        <?php echo Html::endForm(); ?>
                        <div class="search-content mb-0 mt-1"><?=@$info['search-text-content']?></div>
                        <div class="search-suggest">
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="top-bar-mobile py-1">
                <div class="container">
                    <div class="d-flex d-flex justify-content-between">
                        <span class="mr-3 "><i class="fa fa-phone rotate"></i> <a href="tel:<?= $cont->hotline; ?>"><?= $cont->hotline; ?></a></span>
                                                <span><i class="far fa-comment"></i> <a href="sms:<?= $cont->hotline; ?>"><?= $cont->hotline; ?></a></span>
                        <?php
                        if(count($languageList)>1){
                            ?>
                            <div class="lang-vina d-inline-block ml-2">
                                <?php
                                $languageList = Language::getLanguage();
                                foreach ($languageList as $row) {
                                    if (Yii::$app->language != $row->code) {
                                        ?>
                                        <a class="d-inline-block" href="<?= Url::toRoute(['site/change-lang', 'code' => $row->code]) ?>"><img src="<?= $row->path ?>" alt="<?= $row->name ?>"/> </a>
                                    <?php }
                                }?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="bg_overlay_all"></div>
            <div class="mobile-bar d-none d-lg-none">
                <a href="#mobile-menu" class="toggle-menu">
                    <i class="fas fa-bars"></i>
                </a>
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="logo-top d-flex">
                            <a href="<?= Url::home(true) ?>" class="m-auto">
                                <img src="<?= $cont->logo_mobile ?>" alt="<?= $cont->site_title ?> mobile" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-4 mobile-right">
                    <span class="search_mobile_button"><i class="fas fa-search"></i><i class="fas fa-times"></i></span>
                    <a href="<?= Url::to(['site/shopping-order']); ?>" class="cart_th ml-2 d-none">
                        <img src="bundle/css/images/shopping-cart.png" alt="<?= Yii::t('app', 'cart') ?>">
                        <span><?= $count_cart; ?></span>
                    </a>
                </div>
                <div class="col-12 search_mobile_wrap">
                    <div class="search_mobile">
                        <?php echo Html::beginForm(['site/search-news'], 'GET', ['class' => 'search_form']); ?>
                        <input type="text" class="txtkeyword search_keyword" name="keyword" placeholder="<?= Yii::t('app', 'keyword') ?>..." autocomplete="off">
                        <button type="submit"><span><i class="fa fa-search"></i></span></button>
                        <?php echo Html::endForm(); ?>
                    </div>
                </div>
                <nav id="mobile-menu">
                    <ul class="navbar-nav">
                        <?php foreach ($menuList as $row) :
                            $subMenu = $row->getSubMenu();
                            ?>
                            <li class="nav-item">
                                <?php if (!empty($subMenu)) : ?>
                                    <span><i class="fas fa-caret-right"></i> <?= $row->name ?></span>
                                    <ul>
                                        <?php foreach ($subMenu as $row1) :
                                            $subMenu1 = $row1->getSubMenu();
                                            ?>
                                            <li>
                                                <a href="<?= $row1->link ?>"><?= $row1->name ?></a>
                                                <?php if (!empty($subMenu1)) : ?>
                                                    <ul>
                                                        <?php foreach ($subMenu1 as $row2) : ?>
                                                            <li><a href="<?= $row2->link ?>"><?= $row2->name ?></a></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else : ?>
                                    <a href="<?= $row->link ?>"><i class="fas fa-caret-right"></i> <?= $row->name ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach;
                        $menu_top = Menu::getMenu(Menu::LEFT_MENU);
                        if (!empty($menu_top)) {
                            foreach ($menu_top as $row) {
                                ?>
                                <li class="nav-item">
                                    <a href="<?= $row->link; ?>">
                                        <i class="fas fa-caret-right"></i> <?php echo $row->name; ?>
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <?php
        }
        ?>
    </header>
    <?php
    if( ! MyExt::mobileDetect() ) : ?>
        <div class="menu-fixed speacial ">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= Url::home(true) ?>" title="<?= $this->title ?>" class="d-flex align-items-center justify-content-center logo">
                        <img class="my-auto img-contain" src="<?= $cont->logo ?>" alt="<?= $this->title ?> fix" />
                    </a>
                    <div class="menu-cart ">
                        <div class="menubar d-flex justify-content-between align-items-center">
                            <nav class="navbar navbar-expand-md" id="narbarMainMenu">
                                <div class="navbar-collapse collapse">
                                    <ul class="navbar-nav navbar-menu w-100">
                                        <?php foreach ($menuList as $row) :
                                            $subMenu = $row->getSubMenu();
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link text-uppercase <?= !empty($subMenu)?'has-sub':'' ?>" href="<?= $row->link ?>">
                                                    <?= $row->name ?>
                                                </a>
                                                <?php if (!empty($subMenu)) :
                                                    echo "<ul>";
                                                    $j = 0;
                                                    foreach ($subMenu as $mnc) :
                                                        $mnchild1 = $mnc->getSubMenu();
                                                        echo "<li>" . Html::a($mnc->name, $mnc->link);
                                                        if (!empty($mnchild1)) {
                                                            echo '<ul>';
                                                            foreach ($mnchild1 as $mnc1) {
                                                                echo "<li>" . Html::a('<i class="fas fa-angle-right"></i> ' . $mnc1->name, $mnc1->link);
                                                                echo "</li>";
                                                            }
                                                            echo '</ul>';
                                                        }
                                                        echo "</li>";
                                                        $j++;
                                                    endforeach;
                                                    echo "</ul>";
                                                endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="right d-flex align-items-center">
                        <div class="search_desktop_button_fix mr-3">
                            <i class="ri-search-2-line"></i>
                            <i class="fas fa-times" style="display: none;"></i>
                        </div>
                        <div class="hotline d-flex flex-column">
                            <a class="more-button d-inline-block pl-2 pr-3 px-md-41 " href="tel:<?= $cont->hotline; ?>">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-phone mr-2"></i>
                                    <span>
                                        Hotline<br><?= $cont->hotline; ?>
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="wrap-cart d-none">
                            <a href="<?= Url::to(['site/shopping-order']); ?>" class="cart_menu_fix  mr-3 d-flex align-items-center">
                                <span class="d-none"><i><?= $count_cart; ?></i><img src="bundle/css/images/shopping-cart.png" alt="gio hang yeu thich"></span>
                                <span class="icon mr-1"><i class="pos"><?= $count_cart; ?></i><i class="fas fa-shopping-basket"></i></span>
                            </a>
                            <div class="show-cart show-cart-fix show-shop-cart">
                                <div class="wrap">
                                    <div class="title"><i class="fas fa-shopping-basket"></i>  <?= Yii::t('app', 'cart-result', ['count' => '<span>' . $count_cart . '</span>']) ?></div>
                                    <?php
                                    $all_total=0;
                                    if(!empty($cart->getItems())){
                                        $dem=0;
                                        foreach ($cart->getItems() as $row) :
                                            $product = $row->getProduct();
                                            ?>
                                            <div class="_record d-flex d-flex justify-content-between px-3 mb-3  <?php if($dem==0) echo 'mt-3' ?> ">
                                                <a href="<?= $product->getUrl() ?>" class="img-box d-flex mt-1">
                                                    <img class="m-auto" src="<?= $product->getDefaultImg()  ?>" alt="<?= $product->name ?>" title="<?= $product->name ?>" />
                                                </a>
                                                <div class="pl-3">
                                                    <a class="product-name d-block mb-0" href="<?= $product->getUrl(); ?>"><?= $product->name; ?></a>
                                                    <p class="mb-0">
                                                        <?= $row->getQuantity() ?> x <span class="price"><?= MyExt::formatPrice($row->getPrice()) ?></span>
                                                        <a href="<?=Url::to(['site/removecart','id'=>$product->id])?>"><i class="far fa-trash-alt"></i></a>
                                                    </p>
                                                </div>
                                            </div>
                                            <?php
                                            $dem++;
                                        endforeach;
                                    }
                                    else{?>
                                        <div class="content" id="cart-list">
                                            <div class="mess-none-cart">
                                                <?= Yii::t('app', 'shopping-cart-empty') ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if(!empty($cart->getItems())){
                                    ?>
                                    <div class="">
                                        <p class="total px-3 py-2 mb-0 border-top text-center font-weight-bold"><?=Yii::t('app', 'shopping-total')?>: <span class="red"><?= MyExt::formatPrice($cart->getTotalCost()) ?></span> </p>
                                        <a href="<?= Url::toRoute('shopping-order') ?>" class="btn d-block btn-danger border-0 text-uppercase">
                                            <?= Yii::t('app', 'shopping-cart') ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if(count($languageList)>1){
                            ?>
                            <div class="lang-vina ">
                                <?php
                                $languageList = Language::getLanguage();
                                foreach ($languageList as $lang): ?>
                                    <a href="<?= Url::toRoute(['site/change-lang', 'code' => $lang->code]) ?>" class='ml-2'>
                                        <img src="<?= $lang->path ?>" alt="<?= $lang->name ?>" />
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="search_desktop_wrap search_desktop_wrap_fix">
                <div class="container">
                    <div class="search_desktop search_mobile">
                        <?php echo Html::beginForm(['site/search-news'], 'GET', ['class' => 'search_form d-flex']); ?>
                        <input type="text" class="txtkeyword search_keyword" name="keyword"
                               placeholder="<?=@$info['search-text']?>" autocomplete="off">
                        <button type="submit"><span><i class="fa fa-search"></i></span></button>
                        <?php echo Html::endForm(); ?>
                        <div class="search-content mb-0 mt-1"><?=@$info['search-text-content']?></div>
                        <div class="search-suggest">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
    ?>
    <?php if (isset($this->params['breadcrumbs'])): ?>
        <section class="navbar-banner" style="background-image:url('<?= @$info['banner-subpage']['path'] ?>')">
            <?php if (!empty($this->params['big-title'])):
                $bigh1 = !empty($this->params['big-header']) ? 'h1' : 'div';
                ?>
                <?= Html::tag($bigh1, Html::encode($this->params['big-title']), ['class' => 'header-title']) ?>
            <?php endif; ?>
            <div class="breadcrumbs-box">
                <div class="container">
                    <?= Breadcrumbs::widget([
                        'homeLink' => [
                            'label' => Yii::t('app', 'home'),
                            'url' => Yii::$app->homeUrl,
                            'template' => '<li><i class="fas fa-home"></i> {link}</li>'
                        ],
                        'links' => $this->params['breadcrumbs'],
                    ]); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?= $content ?>
    <?php
    $partnerList = Partner::getPartner(Partner::LINK);
    if(!empty($partnerList)){
        $dem=0;
        ?>
        <section class="partner py-4 ">
            <div class="bg1 ">
                <div class="container pd">
                    <div class="wrap">
                        <div class="partner-list owl-carousel owl-theme owl-partner  " >
                            <?php
                            if(!empty($partnerList)){
                                $dem=0;
                                if($dem==6) $dem=1;
                                foreach ($partnerList as $row){?>
                                    <div class="item-wrap">
                                        <div class="item " data-aos="fade-in-up" data-aos-delay="<?=$dem*100?>">
                                            <a class="img-box d-flex" href="<?=$row->url?>">
                                                <img class="img-contain m-auto" src="<?=$row->path?>"  alt="<?=$row->name?>">
                                            </a>
                                        </div>
                                    </div>    
                                    <?php
                                    $dem++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    ?>
    <footer class="pt-4 pt-lg-5"   >
        <div class="logo-ft-wrap ">
            <div class="container">
                <div class="d-md-flex justify-content-between align-items-center wrap">
                    <div class="logo-ft-wrap d-flex flex-column flex-md-row align-items-center">
                        <a class="logo d-flex mr-0 mr-md-3 mb-3 mb-md-0" href="<?= Url::home(true) ?>">
                            <img class="img-contain m-auto" src="<?= $cont->logo_footer ?>" alt="<?= $this->title ?> menu"/>
                        </a>
                        <div class="info text-center">
                            <p class="company text-uppercase mb-1"><?=$cont->company_name?></p>
                            <p class="slogan  mb-0"><?=$cont->slogan?></p>
                        </div>
                    </div>
                    <div class="box copyright text-right text-uppercase mt-3 mt-md-0"><?=strip_tags($cont->copyright)?></div>
                </div>
            </div>
        </div>
        <div class="container py-4 py-lg-5">
            <div class="box footer-wrap d-md-flex justify-content-md-between">
                <div class="company-info mr-lg-0 mr-md-3 mb-4 mb-xl-0">
                    <p class="title text-uppercase mb-3 "><?= @$info['footer-title'] ?></p>
                    <p class="mb-2 mt-3 "><i class="fa fa-map-marker-alt"></i> <strong><?= Yii::t('app','address')?>:</strong> <?= $cont->address; ?></p>
                    <p class="mb-2 "><i class="fa fa-phone rotate"></i> <strong><?= Yii::t('app','phone')?>:</strong> <a href="tel:<?=$cont->hotline; ?>"><?=$cont->hotline; ?></a> - <a href="tel:<?=$cont->phone; ?>"><?=$cont->phone; ?></a></p>
                    <p class="mb-2 "><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:<?=$cont->email; ?>"><?=$cont->email; ?></a></p>
                    <p class="mb-2 "><i class="fas fa-globe-europe"></i> <strong>Website:</strong> <a href="http://<?= $_SERVER['HTTP_HOST'] ?>"><?= $_SERVER['HTTP_HOST']; ?></a></p>
                </div>
                <?php
                $list_agent = json_decode($cont->json_office);
                foreach ($list_agent as $ke => $row){
                    ?>
                    <div class="agent-info company-info mr-lg-0 mr-md-3 mb-4 mb-xl-0">
                        <p class="title text-uppercase mb-3 "><?=$row->name; ?></p>
                        <p class="mb-2 mt-3 "><i class="fa fa-map-marker-alt"></i> <strong><?= Yii::t('app','address')?>:</strong> <?= $row->address; ?></p>
                        <p class="mb-2 "><i class="fa fa-phone rotate"></i> <strong><?= Yii::t('app','phone')?>:</strong> <a href="tel:<?=$row->hotline; ?>"><?=$row->hotline; ?></a> - <a href="tel:<?=$row->phone; ?>"><?=$row->phone; ?></a></p>
                        <p class="mb-2 "><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:<?=$row->email; ?>"><?=$row->email; ?></a></p>
                    </div>
                    <?php
                }
                ?>
                <?php
                $menufooterList = Menu::getMenu(Menu::FOOTER_MENU);
                if(!empty($menufooterList)&&FALSE) {
                    $dem=1;
                    foreach ($menufooterList as $row){
                        $subMenu = $row->getSubMenu();
                        if(!empty($subMenu)){
                            ?>
                            <div class="menu mr-lg-0 mr-md-3 mb-4 mb-xl-0 first">
                                <p class="title mb-3 "><?=$row->name?></p>
                                <ul class="m-0 p-0">
                                    <?php foreach ($subMenu as $row1) {
                                        ?>
                                        <li>
                                            <a class="d-block mb-2" href="<?= $row1->link ?>"><i class="fa fa-angle-right"></i> <?= $row1->name ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php
                            $dem++;
                            if($dem==2) break;
                        }
                    }
                }
                ?>
                <div class="map box mb-3 mb-lg-0">
                    <p class="title mb-3"><?= @$info['map-title'] ?></p>
                    <?=@$info['map-code']?>
                </div>
                <div class="hotline-ft ">
                    <p class="title-hl mb-1 "><?= @$info['hotline-footer'] ?></p>
                    <a class="hotline d-block mb-2" href="tel:<?=$cont->hotline?>"><i class="fa fa-phone rotate"></i> <?=$cont->hotline?></a>
                    <p class="mb-2"><i class="far fa-clock"></i> <?= @$info['time-work'] ?></p>
                    <div class="item network_social">
                        <div class="d-flex align-items-center ">
                            <?= Html::a('<i class="fab fa-facebook-square"></i>', $conf->facebook_url, array('target'=>'_blank','class'=>'facebook_icon rounded mr-2 mr-xl-3'));?>
                            <?= Html::a('<i class="fab fa-youtube-square"></i>', $conf->youtube_url, array('target'=>'_blank','class'=>'youtube rounded mr-2 mr-xl-3'));?>
                            <?= Html::a('<i class="fab fa-twitter-square"></i>', $conf->twitter_url, array('target'=>'_blank','class'=>'twitter_url rounded'));?>
                        </div>
                    </div>
                </div>
                <div class="face box mb-3 mb-lg-0 d-none">
                    <div><div class="fb-page" data-width="250" data-height="190" data-href="<?=$conf->facebook_url; ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
                            <div class="fb-xfbml-parse-ignore">
                                <blockquote cite="<?=$conf->facebook_url; ?>">
                                    <a href="<?=$conf->facebook_url; ?>"><?=$cont->company_name; ?></a>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </footer>
    <?php
    if (MyExt::mobileDetect()){
        ?>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title font-weight-bold text-uppercase" id="exampleModalLabel">Đặt lịch khám</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?= Yii::$app->controller->renderPartial('pages/_search'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
