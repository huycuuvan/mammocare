<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\components\MyExt;
use backend\models\Contact;
use backend\models\Partner;
use backend\models\Menu;
use backend\models\News;
use backend\models\CatNews;
use yii\widgets\Breadcrumbs;

$this->title = ($model->seo_title) ? $model->seo_title : $model->name;
Yii::$app->params['og_description'] = ($model->seo_desc) ? $model->seo_desc : $model->name;

$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => $model->getUrl()];
?>

<section class="content pt-4 news">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-8 col-xl-9 left">
				<?php
//				list($width, $height, $type, $attr) = getimagesize(Yii::getAlias('@root').'/upload/news/1623coffee-cup-leaf919408313.jpg');
//				var_dump($width);
//				var_dump($height);
				?>
				<?php if(!empty($news_list)): ?>
					<div class="list-news">
						<?php
						$i=0;
						foreach ($news_list as $row){
							$cat_home=CatNews::findOne($row->cat_id);
							$url = $row->getUrl();
							$urlCat = $cat_home->getUrl();
							?>
							<div class="item row no-gutters">
								<div class="img-box mt-1 col-12 col-md-5 col-lg-4 mt-md-0">
									<div class="image_inner">
										<img class="lazyload" data-src="<?= $row->path ?>" alt="<?= $row->title ?>">
										<div class="overlay">
											<div class="icon_position_table">
												<div class="icon_container">
													<a href="<?= $url ?>" class="border_round"><i class="fas fa-link"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item-body mt-3 mt-md-0 p-md-2 col-12 col-md-7 col-lg-8 pl-md-4">
									<h5>
										<a class="item-title mb-2 d-block" href="<?= $url ?>"><?= $row->title ?></a>
									</h5>
									<div class="d-flex cat-date mb-2">
										<span class="date mb-0 mr-2 pr-2"><i class="far fa-clock"></i><?=Yii::t('app', 'date')?> <?= date('d/m/Y', strtotime($row->created_at)) ?></span>
										<a class="text-right" href="<?= $urlCat ?>"><i class="fas fa-map-marker-alt"></i> <?= $cat_home->name ?></a>
										
									</div>
									<p class="content mb-0"><?=myExt::getBlock(strip_tags($row->brief),190)?></p>
								</div>
							</div>
							<?php
							$i++;
						}
						?>
						<div class="col-12">
							<?= LinkPager::widget(['pagination' => $pagination,'prevPageLabel' => '« '.Yii::t('app', 'prev'),'nextPageLabel' => Yii::t('app', 'next').' »' ]) ?>
						</div>

					</div>
				<?php
				else:
					echo 'Nội dung đang được cập nhật!';
				endif; ?>
			</div>
			<?=Yii::$app->controller->renderPartial('pages/right')?>
		</div>
	</div>
</section>
