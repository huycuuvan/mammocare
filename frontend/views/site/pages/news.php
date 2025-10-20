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
$this->title = ($model->seo_title) ? $model->seo_title : $model->title;
Yii::$app->params['og_description'] = ($model->seo_desc) ? $model->seo_desc : strip_tags($model->brief);
if (!empty($model->path))
    Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($model->path);
$father = $model->father;
if (!empty($father->father)) {
    $this->params['breadcrumbs'][] = ['label' => $father->father->name, 'url' => ['site/list-news', 'id' => $father->father->id, 'name' => $father->father->url]];
}
$this->params['breadcrumbs'][] = ['label' => $father->name, 'url' => ['site/list-news', 'id' => $father->id, 'name' => $father->url]];
$this->params['overflow']='overflow-none';
?>
<section class="content news py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8  pl-lg-3 left order-lg-last">
                <div class="box-shadow1 bg_white1 p1x-3">
                    <?php
                    if(false){
                        if(!empty($this->params['big-header']) )
                            echo '<h1 class="header-title mb-3 pb-2">'.$this->params['big-title'].'</h1>';
                        else
                            echo '<div class="header-title mb-3 pb-2">'.$this->params['big-title'].'</div>';
                    }
                    ?>
                    <div class="image-box-big mb-3 d-flex1 d-none">
                        <img class="img-cover" src="<?= $model->path ?>" alt="<?= $model->title ?>">
                    </div>
                    <div class="cat-date mb-3"><span class=" date"><i class="far fa-calendar-alt"></i> <?=Yii::t('app', 'date')?> <?= date('d-m-Y', strtotime($model->created_at)) ?></span><span class="view ml-3"><i class="far fa-calendar-alt"></i> <?=Yii::t('app', 'hits')?>  <?=$model->hits?></span> </div>
                    <h1 class="title mb-4"><?= $model->title; ?></h1>
                    <div class="content-style mucluc" data-text="<?=Yii::t('app','mucluc')?>">
                        <div class="offset-content">
                            <?= $model->brief; ?>
                            <?= MyExt::changeContents($model->content); ?>
                        </div>
                    </div>
                    <?php
                    $relatedNews = $model->getRelatedNews();
                    if(!empty($relatedNews)){
                        ?>
                        <div class="news-latest mt-3">
                            <div class="text-uppercase font-weight-bold mb-3"><?=@$info['news-relate-title']?></div>
                            <div class="row list">
                                <?php
                                foreach ($relatedNews as $row){
                                    $cat_home=CatNews::findOne($row->cat_id);
                                    $url = $row->getUrl();
                                    $urlCat = $cat_home->getUrl();
                                    ?>
                                    <div class="col-6 col-md-4 mb-3">
                                        <div class="item">
                                            <div class="img-box">
                                                <div class="img opacity d-flex">
                                                    <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->title ?>">
                                                </div>
                                            </div>
                                            <div class="item-body mt-2">
                                                <a class="item-title mb-0 d-block" href="<?= $url ?>"><?= $row->title ?></a>
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
            </div>
            <?=Yii::$app->controller->renderPartial('pages/left')?>
        </div>
    </div>
</section>
