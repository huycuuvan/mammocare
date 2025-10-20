<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
use backend\models\Page;
use backend\models\Seo;

$seo = Seo::getSeo(Seo::SHOP_PAGE);
if(!empty($seo)) {
  $this->title = $seo->site_title;
  Yii::$app->params['og_description'] = $seo->site_desc;
} else {
  $this->title = Yii::t('app', 'shopping-cart');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shopping-cart'), 'url' => ['site/shopping-cart']];
$cart = \Yii::$app->cart;
?>
<section class="content shopping mb-3">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
				if(!empty($this->params['big-title'])){
					if(!empty($this->params['big-header']) )
						echo '<h1 class="header-title mb-3 pb-2">'.$this->params['big-title'].'</h1>';
					else
						echo '<div class="header-title mb-3 pb-2">'.$this->params['big-title'].'</div>';
				}
				?>
				<div class="shopping-cart">
					<?php if (empty($cart->getItems())): ?>
						<div class="empty-cart">
							<div class="alert alert-success" role="alert">
								<?= Yii::t('app', 'shopping-cart-empty') ?>
							</div>
						</div>

						<div class="button-box text-center">
							<a href="<?= Url::to(['list-product','page'=>1]) ?>" class="btn">
								<i class="fas fa-reply-all"></i> <?= Yii::t('app', 'shopping-continue') ?>
							</a>
						</div>

					<?php else : ?>
						<div class="table-responsive-sm custom-table">
							<table class="table_cart code_product">
								<thead>
								<tr>
									<th>Ảnh</th>
									<th>Tên sản phẩm</th>
									<th>Đơn giá</th>
									<th>S.Lượng</th>
									<th>Giá</th>
									<th>Xóa</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($cart->getItems() as $row) :
									$product = $row->getProduct(); ?>
									<tr class="_record">
										<td data-label="Ảnh" class="hidden img text-center">
											<a href="<?= $product->getUrl() ?>" class="img-box d-flex border mx-auto">
												<img class="m-auto" src="<?= $product->getDefaultImg() ?>" alt="<?= $product->name ?>" title="<?= $product->name ?>" />
											</a>
										</td>
										<td data-label="Sản phẩm">
											<h4 class="product-name d-inline-block mb-0"><a href="<?= $product->getUrl(); ?>"><?= $product->name; ?></a></h4>
										</td>
										<td class="text-center" data-label="Đơn giá"><strong><?= MyExt::formatPrice($row->getPrice()) ?></strong></td>
										<td class="text-center" data-label="S.Lượng"><?= $row->getQuantity() ?></td>
										<td class="text-center" data-label="Giá"><strong><?= MyExt::formatPrice($row->getCost()) ?></strong></td>
										<td data-label="Xóa" class="text-center">
											<a href="<?=Url::to(['site/removecart','id'=>$product->id])?>">x</a>
										</td>
									</tr>
								<?php endforeach; ?>

								<tr>
									<td class="text-right hidden text-right" colspan="4" style="font-weight: 500;"><?= Yii::t('app', 'shopping-total') ?>:</td>
									<td class="text-center" colspan="2" data-label="Tổng tiền"><strong style="font-weight: bold; color: #e00;"><?= MyExt::formatPrice($cart->getTotalCost()) ?></strong></td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="button-box row mt-3">

							<div class="col-12 col-md-5">
								<a href="<?= Url::toRoute('deletecart') ?>" class="btn-delete btn">
									<i class="far fa-trash-alt"></i> Xóa đơn hàng
								</a>
							</div>

							<div class="col-12 text-right col-md-7">
								<a href="<?= Url::to(['list-product','page'=>1]) ?>" class="btn">
									<i class="fas fa-reply-all"></i> <?= Yii::t('app', 'shopping-continue') ?>
								</a>
								<a href="<?= Url::toRoute('shopping-order') ?>" class="btn btn-order">
									<?= Yii::t('app', 'shopping-checkout') ?> <i class="fas fa-angle-double-right"></i>
								</a>
							</div>
						</div>
					<?php endif; ?>


				</div>
			</div>
		</div>
	</div>
</section>
