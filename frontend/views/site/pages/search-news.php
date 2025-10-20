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

                <div class="list-news row ">
                    <?php
                    $i=0;
                    foreach ($news_list as $row) :
                        $cat_home=CatNews::findOne($row->cat_id);
                        $url = $row->getUrl();
                        $urlCat = $cat_home->getUrl();
                        ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-3 mb-md-4 pb-lg-2">
                            <div class="item">
                                <div class="img-box mb-0 mb-md-0">
                                    <div class="image_inner d-flex">
                                        <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->title ?>">
                                    </div>
                                </div>
                                <div class="item-body p-4">
                                    <div class="d-flex  cat-date mb-3 pb-3 border-bottom">
                                        <span class="date mb-0 mr-4"><i class="far fa-calendar-alt"></i> <?=Yii::t('app', 'date')?>  <?= date('d/m/Y', strtotime($row->created_at)) ?></span>
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
