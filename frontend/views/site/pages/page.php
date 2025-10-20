<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
use backend\models\Page;
use backend\models\Partner;
use yii\widgets\Breadcrumbs;

$this->title = ($model->seo_title) ? $model->seo_title : $model->title;
Yii::$app->params['og_description'] = ($model->seo_desc) ? strip_tags($model->seo_desc) : $model->title;

$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['site/page', 'id' => $model->id, 'name' => $model->url]];
?>
<section class="content pt-4 news pb-4 py-lg-5">
    <div class="container">
        <div class="row">

                <?php
                if(!empty($model->editor) ){
                    ?>
            <div class="col-12">
                    <div class="<?= !empty($model->editor) ? 'editor-box' : '' ?> content-news content-style">
                        <?= str_replace('../asset-builder', 'asset-builder', $model->content) ?>
                    </div>
            </div>
                <?php
                }
                else{
                    ?>
                    <div class="col-12 col-lg-8  pl-lg-3 left order-lg-last">
                        <h1 class="header-title mb-3 pb-2"><?= $this->title ?></h1>
                        <div class="<?= !empty($model->editor) ? 'editor-box' : '' ?> content-news content-style">
                            <?= str_replace('../asset-builder', 'asset-builder', $model->content) ?>
                        </div>
                    </div>
                    <?=Yii::$app->controller->renderPartial('pages/left')?>

                <?php
                }
                ?>


            <?php
//            if(empty($model->editor)){
//                echo Yii::$app->controller->renderPartial('pages/right');
//            }
            ?>

        </div>
    </div>
</section>

