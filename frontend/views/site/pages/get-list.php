<?php
use backend\models\Partner;
use backend\models\Cat;
use backend\models\CatNews;
use backend\models\Product;
use backend\models\Link;
use backend\models\News;
use backend\models\Comment;
use backend\models\Album;
use backend\models\Tab;
use backend\models\City;
use backend\models\Supporter;
use backend\models\Seo;
use backend\models\Booking;
use backend\models\Brand;
use backend\components\MyExt;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
$keyword=strip_tags($keyword);
$query = Product::find()->joinWith(['language']);
$query->andWhere(['like', '{{product}}.name', $keyword]);
$query->andWhere(['{{product}}.active' => 1]);
$query->andWhere(['{{language}}.code' => Yii::$app->language]);
$count = $query->count();
$pro_list = $query->orderBy(['ord'=>SORT_ASC,'id' => SORT_DESC])->limit(5)->all();
if(!empty($pro_list))
    foreach ($pro_list as $row){
        $url = $row->getUrl();
        ?>
        <div class="item mb-3 d-flex">
            <a class="img-box d-flex mr-2 border" href="<?= $url; ?>"><img class="my-auto mx-auto" src="<?= $row->getDefaultFullImg() ?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" /></a>
            <div class="info-box my-auto">
                <a class="product-name d-block mb-1" href="<?= $url; ?>"><?= $row->name; ?></a>
                <p class="price red mb-0"><?= myExt::formatPrice($row->sale) ?></p>
            </div>
        </div>
     <?php   
    }
else{?>
    <div class="text-center"><?=Yii::t('app', 'search-empty')?></div>
<?php
    
}
?>