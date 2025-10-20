<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Seo;
use backend\models\Cat;
use backend\models\Brand;
use justinvoelker\separatedpager\LinkPager;

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'products'), 'url' => ['site/list-product']];
$catId = 0;
$submit_url=Url::to(['site/list-product', 'page'=>1]);
if (!empty($cat)) {
	$this->title = ($cat->seo_title) ? $cat->seo_title : $cat->name;
	Yii::$app->params['og_description'] = ($cat->seo_desc) ? $cat->seo_desc : $cat->name;

//	$this->params['breadcrumbs'][] = ['label' => $cat->name, 'url' => $cat->getUrl()];
	$catId = $cat->id;
	if (!empty($cat->path))
		Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($cat->path);
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'product'), 'url' => ['site/list-product','page'=>1]];
	if($cat->parent){
		$this->params['breadcrumbs'][] = ['label' => $cat->father->name, 'url' => $cat->father->getUrl()];
	}
	$this->params['breadcrumbs'][] = ['label' => $cat->name, 'url' => $cat->getUrl()];
	$submit_url=$cat->getUrl();

}
else {
	$seo = Seo::getSeo(Seo::PRODUCT_PAGE);
	$this->title = (!empty($seo->title)) ? $seo->title : $title;
	Yii::$app->params['og_description'] =(!empty($seo->site_desc)) ? $seo->site_desc : $title ;
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'product'), 'url' =>Url::to(['site/list-product', 'page'=>1])];

}
?>
<section class="content py-4 py-lg-5  list-product">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-8 pl-lg-4 order-lg-last">
				<div class="box-shadow1 bg_white1 px1-3">
					<div class="tool_box d-flex justify-content-between align-items-center pb-2 mb-3" data-content="<?=$submit_url?>">
						<div class="left_tool_box">
							<label class="mb-0 font-weight-bold"><?=Yii::t('app','sx')?>:</label>
							<?php
							$i=0;
							foreach (Yii::$app->params["sort_by_ddl"] as $key => $val) {
								if (empty($_GET['sort_by'])) {
									?><label class="d-none d-md-inline-block"><input name="order_by" <?=($i == 0)?'checked="checked"':''; ?> type="radio" value="<?=$key; ?>"><?=Yii::t('app',$val); ?></label><?php
								} else {
									?><label class="d-none d-md-inline-block"><input name="order_by" <?=($_GET['sort_by'] == $key)?'checked="checked"':''; ?> type="radio" value="<?=$key; ?>"><?=Yii::t('app',$val); ?></label><?php
								}
								$i++;
							}
							$sort_by=0;
							//						,'options' => array($_GET['ord']=>array('selected'=>true))
							if(isset($_GET['sort_by'])) $sort_by=$_GET['sort_by'];
							echo Html::dropDownList('sort_by', $sort_by,Yii::$app->params["sort_by_ddl"] , array('prompt' => 'Mặc định','class'=>'d-md-none'));
							?>
						</div>
					</div>
                    <?php
                    if (!empty($cat)) {
                        if($cat->description2) {
                            ?>
                                <div class="wrap-content mb-3 mb-lg-4 pb-3 border-bottom">
                                    <div class="content-style   expand-box">
                                        <?= $cat->description2; ?>
                                        <div class="text-center "><span class="d-inline-block open-expand-button"><?=Yii::t('app','more1')?></span> </div>
                                    </div>
                                </div>

                            <?php
                        }
                    }
                    ?>
                    <div class="list-products row no-gutters <?php if(Yii::$app->session->has('show_product') && Yii::$app->session->get('show_product')!=NULL) echo Yii::$app->session->get('show_product');else echo Yii::$app->params["show_product"]?>">
						<?php
						if(!empty($product_list))
							foreach ($product_list as $row) :
                                $url = $row->getUrl();
                                $productImg = $row->imgs;
                                $prod_img2='';
                                if(count($productImg)>1)
                                    $prod_img2 = $productImg[1];
                                $urlCat=$row->category?$row->category->getUrl():'#';
								?>
								<div class="item-wrap col-12 col-md-4 ">
                                    <div class="item ">
                                        <div class="product-box" onclick="location.href='<?= $url ?>';">
                                            <div class="wrap-img-box">
                                                <a class="img-box d-flex" href="<?= $url; ?>">
                                                    <img class="img-cover" src="<?= $row->path?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" />
                                                </a>
                                                <div class="shop-item-meta">
                                                    <a href="<?= Url::to(['site/addtocart','id'=>$row->id]); ?>" class="add_to_cart  d-inline-block " rel="nofollow" >
                                                        <i class="fas fa-shopping-basket"></i>
                                                    </a>
                                                </div>

                                            </div>
                                            <div class="info-box p-2 p-lg-3">
                                                <h4 class="product-name mb-2  "><a class="" href="<?= $url; ?>"><?= $row->name; ?></a></h4>
                                                <p class="price mb-0 "><?=Yii::t('app','price')?>: <span><?= MyExt::formatPrice($row->sale); ?></span></a></p>
                                                <p class="brief mb-0 "><?=@$info['product-number']?>: <span><?= ($row->description2); ?></span></a></p>
                                                <p class="info mb-2 "><?=@$info['product-order']?>: <span><?= ($row->description3); ?></span></a></p>
                                            </div>
                                            <a class="view-more d-none px-3 px-lg-4 mx-auto text-center" href="<?= $url; ?>"><?= Yii::t('app','more2'); ?></a>
                                        </div>
                                    </div>
								</div>
							<?php endforeach; ?>
                        <div class="col-12">
                            <?= LinkPager::widget(['pagination' => $pagination,'maxButtonCount' => 6,
                                'prevPageLabel' => '«',
                                'nextPageLabel' => '»',
                                'prevPageCssClass' => 'prev hidden-xs',
                                'nextPageCssClass' => 'next hidden-xs',
                                'activePageAsLink' => false, ]) ?>
                        </div>
					</div>
                    <?php
                    if (!empty($cat)) {
                        if($cat->description) {
                            ?>
                            <div class="content-style mt-3 mt-lg-4 mt-xl-5 pt-3 border-top expand-box">
                                <?= $cat->description; ?>
                                <div class="text-center"><span class="d-inline-block open-expand-button">Xem thêm</span> </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
			</div>
			<?=Yii::$app->controller->renderPartial('pages/right')?>
		</div>

	</div>
</section>