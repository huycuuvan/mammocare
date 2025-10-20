<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Contact;
use backend\models\Partner;
use backend\models\Menu;
use backend\models\News;
use backend\models\Seo;
use backend\models\CatNews;
use yii\widgets\Breadcrumbs;
use justinvoelker\separatedpager\LinkPager;

$this->title = Yii::t('app', 'search') . ': ' . $keyword;
Yii::$app->params['og_description'] = $this->title;

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$catId=0;
?>
<section class="content py-4 py-lg-5   list-product">
    <div class="container">
        <div class="row">

            <div class="col-12 col-lg-12 col-xl-12 ">
                <div class="wrap-head mb-3">
                    <?php
                    if(!empty($this->params['big-title'])){
                        if(!empty($this->params['big-header']) )
                            echo '<h1 class="header-title mb-2 pb-2">'.$this->params['big-title'].'</h1>';
                        else
                            echo '<div class="header-title mb-2 pb-2">'.$this->params['big-title'].'</div>';
                    }
                    ?>
                    <div class="tool_box d-flex d-flex justify-content-between align-items-center pb-2">
                        <div class="search-result">
                            <?= Yii::t('app', 'search-result', [
                                'count' => '<span>' . $count . '</span>',
                                'keyword' => '<span class="red">' . $keyword . '</span>'
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="list-products row no-gutters">
                    <?php
                    $i=0;
                    foreach ($news_list as $row) :
                        $url = $row->getUrl();
                        $productImg = $row->imgs;
                        $prod_img2='';
                        if(count($productImg)>1)
                            $prod_img2 = $productImg[1];
                        ?>
                        <div class="col-12 col-md-4 col-lg-3  item-wrap">
                            <div class="item ">
                                <div class="product-box" onclick="location.href='<?= $url ?>';">
                                    <div class="wrap-img-box">
                                        <a class="img-box d-flex" href="<?= $url; ?>">
                                            <img class="img-cover" src="<?= $row->path?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" />
                                        </a>
                                        <div class="shop-item-meta">
                                            <a href="<?= Url::to(['site/addtocart','id'=>$row->id]); ?>" class="add_to_cart  d-inline-block " rel="nofollow" >
                                                <i class="fas fa-shopping-basket"></i>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="info-box p-2 p-lg-3">
                                        <h4 class="product-name mb-2  "><a class="" href="<?= $url; ?>"><?= $row->name; ?></a></h4>
                                        <p class="price mb-0 "><?=Yii::t('app','price')?>: <span><?= MyExt::formatPrice($row->sale); ?></span></a></p>
                                        <p class="brief mb-0 "><?=@$info['product-number']?>: <span><?= ($row->description2); ?></span></a></p>
                                        <p class="info mb-2 "><?=@$info['product-order']?>: <span><?= ($row->description3); ?></span></a></p>
                                    </div>
                                    <a class="view-more d-none px-3 px-lg-4 mx-auto text-center" href="<?= $url; ?>"><?= Yii::t('app','more2'); ?></a>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endforeach;
                    ?>

                    <div class="col-12">
                        <?= LinkPager::widget(['pagination' => $pagination,'maxButtonCount' => 6,
                            'prevPageLabel' => '«',
                            'nextPageLabel' => '»',
                            'prevPageCssClass' => 'prev hidden-xs',
                            'nextPageCssClass' => 'next hidden-xs',
                            'activePageAsLink' => false, ]) ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
