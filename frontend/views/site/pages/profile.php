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
$this->title = $model->name;
Yii::$app->params['og_description'] = $model->name;

if (!empty($model->path))
    Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($model->path);

$father = $model->cat;

//if (!empty($father->cat)) {
//    $this->params['breadcrumbs'][] = ['label' => $father->cat->name, 'url' => ['site/list-profiles', 'id' => $father->cat->id, 'name' => $father->cat->url]];
//}

$this->params['breadcrumbs'][] = ['label' => $father->name, 'url' => ['site/list-profiles', 'id' => $father->id, 'name' => $father->url]];
$this->params['overflow']='overflow-none';
?>
<section class="content view-profile py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8  pr-lg-4 left ">
                <div class="row view-job pd10">
                    <div class="col-12 col-md-5 ">
                        <div class="box-shadow bg_white info-profile p-3">
                            <div class="mb-3">
                                <div class="img-box border ">
                                    <img  src="<?=$model->path?>" alt="<?=$model->name?>">
                                </div>
                            </div>
                            <div class="info">
                                <p><i class="far fa-clock"></i> <?=Yii::t('app','birthday')?>: <?=date('d/m/Y',strtotime($model->birthday))?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 mt-4 mt-md-0">
                        <div class="box-shadow bg_white detail-profile p-3">
                            <p class="mb-2 name"><strong><?=$model->name?></strong></p>
                            <p class="mb-2"><strong><?=@$info['profile-desired-job']?></strong>: <?=$model->cat?$model->cat->name:$model->desired_job_id?></p>
                            <p class="mb-2"><strong><?=@$info['profile-exp']?></strong>: <?=$model->title?></p>
                            <p class="mb-2"><strong><?=Yii::t('app','address')?></strong>: <?=$model->address?></p>

                            <?php
                            if($model->self_description){
                            ?>
                            <div class="box mt-4">
                                <div class="header-content mb-2 mb-lg-3 ">
                                    <p class="header-title mb-2 py-0 pb-lg-2"><?=@$info['profile-about']?></p>
                                </div>
                                <div class="mt-3">
                                    <div class="content-style mb-2"><?=strip_tags($model->self_description)?></div>
                                </div>
                            </div>
                            <?php
                            }
                            if($model->course || $model->objective || $model->graduated_year || $model->height || $model->weight){
                            ?>
                            <div class="box mt-4">
                                <div class="header-content mb-2 mb-lg-3 ">
                                    <p class="header-title mb-2 py-0 pb-lg-2"><?=@$info['profile-progress']?></p>
                                </div>
                                <div class="mt-3">
                                    <table class="table table-striped table-bordered">
                                        <tr class="table-primary">
                                            <th><?=@$info['profile-working-unit']?></th>
                                        </tr>
                                        <?php
                                        if($model->course){
                                        ?>
                                            <tr>
                                                <td><?=$model->course?></td>
                                            </tr>
                                        <?php
                                        }
                                        if($model->objective){
                                        ?>
                                            <tr>
                                                <td><?=$model->objective?></td>
                                            </tr>
                                        <?php
                                        }
                                        if($model->graduated_year){
                                        ?>
                                            <tr>
                                                <td><?=$model->graduated_year?></td>
                                            </tr>
                                        <?php
                                        }
                                        if($model->height){
                                        ?>
                                            <tr>
                                                <td><?=$model->height?></td>
                                            </tr>
                                        <?php
                                        }
                                        if($model->weight){
                                        ?>
                                            <tr>
                                                <td><?=$model->weight?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <?php
                $orther_profile=$model->getRelated();
                if(!empty($orther_profile)){
                    ?>
                    <div class="box-shadow1 bg_white1 mt-4 mt-lg-4 mt-xl-5 orthers-product px1-3">
                        <div class="header-box mb-3 mb-lg-4 text-center" >
                            <p class="pb-2 title mb-0" ><?=@$info['related-profile']; ?></p>
                        </div>
                        <div class="content home-project row pd8">
                            <?php foreach ($orther_profile as $row) :
                                $url = $row->getViewUrl();
                                ?>
                                <div class="item-wrap col-12 col-md-4 mb-3">
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
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <?php
                }
                ?>
            </div>
            <?=Yii::$app->controller->renderPartial('pages/left-profile')?>
        </div>
    </div>
</section>

