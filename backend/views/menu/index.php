<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\Menu;
use backend\components\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quản lý';
$this->params['breadcrumbs'][] = ['label' => 'Menu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row no-gutters">
    <div class="col-md-12">
        <div class="link-index">

            <div class="row no-gutters" id="menu_page">
                <?php
                foreach (Menu::getPosition() as $key => $val)
                {
                    ?>
                    <div class="white_bg col-6 grid-view" data-url="<?=Url::to($this->context->id."/update-ajax"); ?>">
                        <?= Category::widget([
                            'name' => $val,
                            'data' => Menu::getAdmin($key),
                            'actionUpdate' => 'menu/update',
                            'actionDelete' => 'menu/delete',
                            'actionSort' => 'menu/sort',
                            'moreLink' => [
                                ['label' => '+Thêm menu', 'url' => Url::to(["menu/create", "position" => $key])]
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
