<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\CatNews;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\components\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$catnews_filter = CatNews::getCatNewsDDL();

$this->title = 'Danh mục tin';
$this->params['breadcrumbs'][] = ['label' => 'Tin tức', 'url' => ['news/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>

<div class="row no-gutters">
    <div class="col-md-7">
        <div class="cat-news-index">
            <div class="row no-gutters" id="menu_page">

                <div class="white_bg col-12 grid-view" data-url="<?=Url::to($this->context->id."/update-ajax"); ?>">
                    <?= Category::widget([
                        'data' => CatNews::getAdmin(),
                        'checkBox' => ['home' => 'T.Chủ', 'active' => 'H.Thị'],
                        'actionUpdate' => 'cat-news/update',
                        'actionDelete' => 'cat-news/delete',
                        'actionSort' => 'cat-news/sort',
                    ]); ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile("@web/js/menu.js", [
    'depends' => [\backend\assets\AppAsset::className()],
    'position' => \yii\web\View::POS_END]
);
?>
