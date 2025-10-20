<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\City;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\components\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Thành phố';
$this->params['breadcrumbs'][] = $this->title;

$this->params['vn-navbar'][] = Html::a('<i class="fas fa-plus"></i> Thêm mới', ['create'], ['class' => 'btn btn-primary rounded-sm']);
$this->params['vn-navbar'][] = Html::a('<i class="fas fa-bars"></i> Quản lý', ['index'], ['class' => 'btn btn-success rounded-sm']);
?>

<div class="row no-gutters">
    <div class="col-md-7">
        <div class="link-index">

            <div class="row no-gutters" id="menu_page">
                <?php
                foreach (City::getPosition() as $key => $val)
                {
                    ?>
                    <div class="white_bg col-12 grid-view" data-url="<?=Url::to($this->context->id."/update-ajax"); ?>">
                        <?= Category::widget([
                            'name' => $val,
                            'data' => City::getAdmin($key),
                            'actionUpdate' => 'city/update',
                            'actionDelete' => 'city/delete',
                            'actionSort' => 'city/sort',
                            'moreLink' => [
                                ['label' => '+Thêm thành phố', 'url' => Url::to(["city/create", "position" => $key])]
                            ]
                        ]); ?>
                    </div>
                    <?php
                }
                ?>
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
