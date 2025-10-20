<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Hosting;
use yii\bootstrap\ActiveForm;
use backend\models\Seo;
use backend\models\Partner;
use yii\widgets\Breadcrumbs;

$seo = Seo::getSeo(Seo::ABOUT_PAGE);

if(!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = 'Giới thiệu';
}
$this->params['breadcrumbs'][] = ['label' => @$info['about-top-title'], 'url' => ['about']];
?>
<section class="slider">
    <div class="item d-flex min-height background">
        <div class="container my-auto">
            <div class="row">
                <div class="col-md-7 col-12">
                    <p class="mb-md-3 mb-4 name"><?=@$info['about-top-title']?></p>
                    <p class="mb-2"><?=@$info['about-top-description']?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if(!empty($this->params['breadcrumbs'])):
    ?>
    <section class="navbar-banner bg-silver" >
        <div class="breadcrumbs-box">
            <div class="container">
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('app', 'home'),
                        'url' => Yii::$app->homeUrl
                    ],
                    'links' => $this->params['breadcrumbs'],
                ]); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<section class="content about-us pt-5">
    <div class="container">
        <div class="row justify-content-center about-info">
            <div class="col-12 col-md-10">
                <?=$cont->footer?>
            </div>
        </div>
        <div class="row justify-content-center about-content py-5">
            <div class="col-12 col-md-3 pt-md-4 pt-0 about-left">
                <div class="rounded shadow square p-4 mt-md-5" >
                    <h5 class="mb-3 text-light"><?=@$info['about-page-description']?></h5>
                    <a class="btn btn-red" href="<?=@$info['about-page-url']?>"><?=@$info['about-page-button']?></a>
                </div>
            </div>
            <div class="col-12 col-md-8 about-right">
                <div class="row">
                    <?php
                    $about_img = Partner::getPartner(Partner::ABOUT_IMG,4);
                    if(!empty($about_img)){
                        $row=$about_img[0];
                        ?>
                        <div class="col-12 col-md-7 left">
                            <div class="row">
                                <div class="col-12 col-md-5 px-md-2 mt-4 mt-md-0 col-one">
                                    <img src="<?=$row->path?>" alt="<?=$row->name?>" class="rounded shadow object-fit">
                                    <?php
                                    if(count($about_img)>1){
                                        $row=$about_img[1];
                                        ?>
                                        <div class="row justify-content-end">
                                            <div class="col-12 col-md-7">
                                                <img src="<?=$row->path?>" alt="<?=$row->name?>" class="rounded shadow mt-4 object-fit">
                                            </div>
                                        </div>
                                    <?php }
                                    ?>

                                </div>
                                <?php
                                if(count($about_img)>2){
                                    $row=$about_img[2];
                                    ?>
                                    <div class="col-12 col-md-7 pt-md-4 col-two">
                                        <img src="<?=$row->path?>" alt="<?=$row->name?>" class="rounded shadow object-fit mt-md-5 mt-4">
                                    </div>
                                <?php }
                                ?>

                            </div>
                        </div>
                        <?php if(count($about_img)>3){
                            $row=$about_img[3];
                            ?>
                            <div class="col-12 col-md-5 right px-md-2">
                                <img src="<?=$row->path?>" class="rounded shadow object-fit mt-md-5 mt-4" alt="<?=$row->name?>">
                            </div>
                        <?php }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <?php
    $about_link = Partner::getPartner(Partner::ABOUT_LINK,2);
    if(!empty($about_link)){
        ?>

        <div class="bg-silver py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <?php
                    $dem=0;
                    foreach ($about_link as $row){
                        $class='';
                        if($dem==0) $class=' mb-3 mb-md-0';
                        ?>
                        <div class="col-md-5 col-12 <?=$class?>">
                            <a class="font-weight-bold text-decoration-none rounded border border-red p-4 text-center d-block" href="<?=$row->url?>"><?=$row->name?></a>
                        </div>
                        <?php
                        $dem++;
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

</section>