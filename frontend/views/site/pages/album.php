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
$this->title = ($model->seo_title) ? $model->seo_title : $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'gallery'), 'url' => ['site/gallery','page'=>1]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['site/album', 'id' => $model->id, 'name' => $model->url]];
if(!empty($model->imgs)){
    $all_picture = $model->getImgs()->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->all();
}
?>
<section class="content album py-4 py-lg-5">
    <div class="container">
        <div class="row gallery-picture pd10">
            <?php
            $dem=0;
            $i=0;
            $ss=ceil(count($all_picture)/3);
            if(!empty($model->imgs))
                foreach ($all_picture as $row):
                    $check=0;
                    if($row->code==''){
                        $imgPath=$row->getFullImg();
                    }
                    else{
                        $imgPath='https://www.youtube.com/watch?v='.$row->code;
                        $check++;
                    }
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <div class="item-media ">
                            <div class="d-flex img-box <?=$check>0?'has-video':''?>">
                                <img class="img-cover" src="<?= $row->path ?>" alt="<?= $row->alt ?>" />
                            </div>
                            <div class="media-links">
                                <div class="links-wrap">
                                    <a class="link-zoom photoswipe-link" href="<?= $imgPath ?>" data-fancybox="gallery" data-caption="<?= $row->alt ?>" title="<?= $row->alt; ?>"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $dem++;
                    $i++;
                endforeach;
            ?>
        </div>
    </div>
</section>