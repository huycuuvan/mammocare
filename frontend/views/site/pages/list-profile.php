<?php
use yii\helpers\Html;
use yii\helpers\Url;
use justinvoelker\separatedpager\LinkPager;
use backend\components\MyExt;
use backend\models\Contact;
use backend\models\Partner;
use backend\models\Menu;
use backend\models\News;
use backend\models\Seo;
use yii\widgets\Breadcrumbs;

if (!empty($model)){
    $seo = Seo::getSeo(Seo::APP_PAGE);
    if(!empty($seo)) {
        $this->title = $seo->site_title.' '.$model->name;
        Yii::$app->params['og_description'] = $seo->site_desc;
        $this->params['breadcrumbs'][] = ['label' => $seo->site_title , 'url' => Url::to(['site/list-profile','page'=>1])];
    } else {
        $this->title = Yii::t('app', 'crew');
        $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'crew') , 'url' => Url::to(['site/list-profile','page'=>1])];
    }
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => $model->getUrl()];
}
else{
    $seo = Seo::getSeo(Seo::APP_PAGE);
    if(!empty($seo)) {
        $this->title = $seo->site_title;
        Yii::$app->params['og_description'] = $seo->site_desc;
    } else {
        $this->title = Yii::t('app', 'crew');
    }
    $this->params['breadcrumbs'][] = ['label' => $this->title , 'url' => Url::to(['site/list-profile','page'=>1])];
}


//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'contact'), 'url' => ['site/contact']];
?>

<section class="content pt-4 py-lg-5  news">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8  pr-lg-4 left ">
                <div class="home-project row pd10">
                    <?php
                    $i=0;
                    foreach ($crews_list as $row) :
                        $url = $row->getViewUrl();
                        ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-3 mb-md-4 pb-lg-2 item-wrap">
                            <div class="item">
                                <div class="profile-box">
                                    <div class="wrap-img-box">
                                        <a class="img-box d-flex mx-auto" href="<?= $url; ?>">
                                            <img class="img-cover" src="<?= $row->path?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" />
                                        </a>
                                    </div>
                                    <div class="info-box pt-3 text-center">
                                        <div class="product-name mb-2 px-3"><a class="" href="<?= $url; ?>"><?= $row->name; ?></a></div>
                                        <p class="profile-desired-job mb-1"><?=@$info['profile-desired-job']?>: <strong><?=$row->cat?$row->cat->name:$row->desired_job_id?></strong></p>
                                        <p class="profile-exp mb-1"><?=@$info['profile-exp']?>: <strong><?=$row->title?></strong></p>
                                        <a class="view-more " href="<?= $url; ?>"><?= @$info['profile-more']; ?></a>
                                    </div>
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
            <?=Yii::$app->controller->renderPartial('pages/left-profile')?>
        </div>

    </div>
</section>
