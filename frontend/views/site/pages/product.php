<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Contact;
use backend\models\Cat;
use backend\models\Product;
use backend\models\Brand;
use backend\models\News;
use backend\models\Partner;
use yii\helpers\Url;
$catId=$model->category_id;
$this->title = ($model->seo_title) ? $model->seo_title : $model->name;
Yii::$app->params['og_description'] = ($model->seo_desc) ? $model->seo_desc : strip_tags($model->brief);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'product'), 'url' => ['site/list-product','page'=>1]];
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => $model->category->getUrl()];

if (!empty($model->path))
	Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($model->path);

?>
<section class="content product py-4 py-lg-5 list-product">
	<div class="container">
		<div class="row">
			<div class="col-12 ">
				<div class="box-shadow1 bg_white1 p1-3">
					<div class="row">
						<div class="col-12 col-md-6 col-lg-6 mb-4 mb-md-0">
							<?php
							$productImg = $model->imgs;
							$imgPath = $model->getDefaultFullImg();
							?>
							<div class="product-image">
								<a href="<?= $imgPath; ?>" class="entry-hover zoom big-image d-flex mb-4" data-fancybox="images" rel="img_group" id="big_image">
									<img class="lazyload m-auto" data-src="<?=$imgPath; ?>" alt="<?=$model->name; ?>" title="<?=$model->name; ?>" />
								</a>
								<p class="text-center"><i>(<?= Yii::t('app','click') ?>)</i></p>
								<div class="owl-carousel owl-theme owl-productimg">
									<?php
									if(!empty($productImg))
										foreach ($productImg as $row):

											?>
											<div class="item">
												<a class="thumb-img d-flex" <?php if($imgPath!= str_replace('/thumb/','/',$row->path)) echo 'data-fancybox="images"'?>  href="<?= $row->getFullImg() ?>">
													<img  class="lazyload m-auto" data-src="<?= $row->path; ?>" alt="<?= $model->name; ?>" />
												</a>
											</div>
										<?php endforeach; ?>
								</div>

							</div>
						</div>
						<div class="col-12 col-md-6 col-lg-6 product-brief">
							<h1 class="title mb-2 pb-2 border-0"><?= $model->name; ?></h1>
                            <div class="price-more  p-3 border mb-3">
                                <div class="row pd10">
                                    <p class="price col-12 col-md-6  mb-2 pb-2 border-bottom"><?=Yii::t('app','price')?>: <span><?= MyExt::formatPrice($model->sale); ?></span></a></p>
                                    <p class="brief col-12 col-md-6  mb-2 pb-2 border-bottom"><?=@$info['product-number']?>: <span><?= ($model->description2); ?></span></a></p>
                                    <p class="info mb-0 col-12 col-md-6"><?=@$info['product-order']?>: <span><?= ($model->description3); ?></span></a></p>
                                    <span class="col-12 col-md-6 border-right1 d-inline-block"><?= Yii::t('app','hits')?>: <?=$model->hits?$model->hits:0?></span>

                                </div>

                                <span class="status d-none"><?=$model->status=1?'Hàng mới':($model->status=2?'Còn hàng':'Hết hàng')?></span>
							</div>

                            <div class="content-style">
								<?= $model->brief; ?>
							</div>
							<div class="product-order my-2 ">
								<?= Html::beginForm(['site/addcart'], 'POST', ['class' => 'shopcart_form form_row']);?>
								<input type="hidden" name="id" value="<?=$model->id; ?>" />
								<div class="row no-gutters">
									<div class="col-xs-12 col-lg-6 col-xl-5 pr-xl-0 input_cart col-md-6">
										<button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty) &amp; qty > 1 ) result.value--;return false;" class="btn-minus btn-cts" type="button">–</button>
										<input type="text" name="quantity" id="qty" value="1" min="1" max="10">
										<button onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN(qty)) result.value++;return false;" class="btn-plus btn-cts" type="button">+</button>
									</div>
									<div class=" col-12 col-lg-6 col-xl-7 pl-xl-0 button_cart col-md-6">
										<button type="submit" name="btn_order"><strong><?= Yii::t('app','shopping-order')?></strong></button>
									</div>
									<div class="col-12 mt-2 d-none">
										<a href="tel:<?= $cont->hotline; ?>" class="hotline_cart">
											<span>Hotline</span>
											<p><?= $cont->hotline; ?></p>
										</a>
									</div>
								</div>
								<?= Html::endForm(); ?>
							</div>

						</div>
					</div>
				</div>
				<div class="box-shadow1 bg_white1 p1-3 mt-3 mt-lg-4 mt-xl-5 product-description">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="desc1-tab" data-toggle="tab" href="#desc1" role="tab" aria-controls="desc1" aria-selected="true"><?= @$info['product-detail-title'] ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="desc2-tab" data-toggle="tab" href="#desc2" role="tab" aria-controls="desc1" aria-selected="true"><?= @$info['certificate'] ?></a>
                        </li>

                    </ul>
                    <div class="content-page">
                        <div class="tab-content p-4" id="myTabContent">
                            <div class="tab-pane fade  show active" id="desc1" role="tabpanel" aria-labelledby="desc1">
                                <div class="content-style mucluc" data-text="<?=Yii::t('app','mucluc')?>">
                                    <div class="offset-content">
                                        <?= $model->description?MyExt::changeContents($model->description):Yii::t('app','update_content'); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade   " id="desc2" role="tabpanel" aria-labelledby="desc1">
                                <?php
                                $linkList = Partner::getPartner(Partner::ADS);
                                if(!empty($linkList)){
                                    ?>
                                    <div class="certificate mt-3" >
                                        <div class="row pd8">
                                            <?php
                                            foreach ($linkList as $row){
                                                ?>
                                                <div class="item mb-3 col-6 col-md-4 col-lg-3 col-xl-2">
                                                    <div class="d-flex">
                                                        <img class="img-contain m-auto" src="<?= $row->path?>" alt="<?= $row->name ?>" title="<?= $row->name ?>" />
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>

				</div>
				<?php
				$orther_products=$model->getOtherCatProduct();
				if(!empty($orther_products)){
					?>
					<div class="box-shadow1 bg_white1 mt-3 mt-lg-4 mt-xl-5 orthers-product px1-3">
                        <div class="header-box mb-3 mb-lg-4 text-center" >
                            <p class="pb-2 title mb-0" ><?=Yii::t('app', 'related-product'); ?></p>
                        </div>
						<div class="content list-products row no-gutters">
							<?php foreach ($orther_products as $row) :
                                $url = $row->getUrl();
                                $productImg = $row->imgs;
                                $prod_img2='';
                                if(count($productImg)>1)
                                    $prod_img2 = $productImg[1];
                                $urlCat=$row->category?$row->category->getUrl():'#';
								?>
                                <div class="item-wrap col-12 col-md-4 col-lg-3">
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
						</div>

					</div>

					<?php
				}
				?>
			</div>
<!--			--><?//=Yii::$app->controller->renderPartial('pages/right',['cat_id'=>$catId])?>


		</div>
	</div>
</section>