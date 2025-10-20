<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyExt;
use backend\models\Page;
use backend\models\Seo;
use backend\models\Province;
use backend\models\District;
use backend\models\Ward;
use backend\models\Contact;
use yii\bootstrap\ActiveForm;

$seo = Seo::getSeo(Seo::ORDER_PAGE);
if(!empty($seo)) {
    $this->title = $seo->site_title;
    Yii::$app->params['og_description'] = $seo->site_desc;
} else {
    $this->title = Yii::t('app', 'shopping-order');
}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shopping-checkout'), 'url' => ['site/shopping-order']];
$cart = \Yii::$app->cart;
?>
<section class="content shopping py-4 bg_grey_half">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 pr-md-3 pr-lg-4">
                <div class="shopping-order">
                    <?php if (Yii::$app->session->hasFlash('order') ): ?>
                        <div class="alert alert-success" role="alert">
                            <?= Yii::$app->session->getFlash('order'); ?>
                        </div>
                        <?php
                    elseif(empty($cart->getItems())): ?>
                        <div class="empty-cart">
                            <div class="alert alert-success text-center" role="alert">
                                <?= Yii::t('app', 'shopping-cart-empty') ?>
                            </div>
                        </div>

                        <div class="button-box text-center">
                            <a href="<?= Url::to(['list-product','page'=>1]) ?>" class="btn btn-sucess">
                                <?= Yii::t('app', 'shopping-continue') ?>
                            </a>
                        </div>
                        <?php
                    else:
                        $checked=1;
                        $arr_district=[];
                        $arr_ward=[];
                        ?>
                        <p class="title text-uppercase"><?=Yii::t('app','billing-detail')?></p>
                        <?php $form = ActiveForm::begin(['id' => 'order-form', 'enableClientScript' => false, 'enableClientValidation' => false]); ?>
                        <div class="row">
                            <?= $form->field($model, 'fullname',['options' => ['class' => 'form-group col-12 mb-0']])->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'fullname')])->label(false) ?>

                            <?= $form->field($model, 'email',['options' => ['class' => 'form-group col-6 mb-0 pr-1']])->textInput(['placeholder' => Yii::t('app', 'email')])->label(false); ?>

                            <?= $form->field($model, 'phone',['options' => ['class' => 'form-group col-6 mb-0 pl-1']])->textInput(['placeholder' => Yii::t('app', 'phone')])->label(false); ?>

                            <?= $form->field($model, 'address',['options' => ['class' => 'form-group col-12 mb-0']])->textInput(['placeholder' => Yii::t('app', 'address')])->label(false); ?>
                            <div class="col-12 col-md-4  mb-0 pr-md-2">
                                <?= $form->field($model, 'province',['options' => ['class' => 'form-group province wrapper-select']])->dropDownList(Province::getAllProvinceDDL(), ['prompt' => Yii::t('app','select-city')]); ?>
                            </div>
                            <div class="col-12 col-md-4  mb-0 px-md-0">
                                <?php
                                if(empty($model->province))
                                    echo $form->field($model, 'district',['options' => ['class' => 'form-group district wrapper-select']])->dropDownList($arr_district, ['prompt' =>  Yii::t('app','select-city')]);
                                else{
                                    if(empty($model->district)){
                                        $find=District::getDistrict($model->province);
                                        $model->district=$find[0]->id;
                                    }
                                    echo $form->field($model, 'district',['options' => ['class' => 'form-group district wrapper-select']])->dropDownList(District::getDistrictDDL($model->province));
                                }
                                ?>
                            </div>
                            <div class="col-12 col-md-4 mb-0 pl-md-2">
                                <?php
                                if(empty($model->district))
                                    echo $form->field($model, 'ward',['options' => ['class' => 'form-group ward wrapper-select ']])->dropDownList($arr_ward, ['prompt' => Yii::t('app','select-ward')]);
                                else{
                                    if(empty($model->ward)){
                                        $find=Ward::getWard($model->district);
                                        $model->ward=$find[0]->id;
                                    }
                                    echo $form->field($model, 'ward',['options' => ['class' => 'form-group ward wrapper-select']])->dropDownList(Ward::getWardDDL($model->district));
                                }
                                ?>
                            </div>
                            <?= $form->field($model, 'content',['options' => ['class' => 'form-group col-12 mb-0']])->textarea(['rows' => 3, 'placeholder' => Yii::t('app', 'message')])->label(false); ?>
                            <p class="col-12 title text-uppercase"><?=Yii::t('app','payment')?></p>
                            <div class="col-12 mb-3">
                                <div class="custom_radio_box border rounded">
                                    <div class="radio-wrap show">
                                        <div class="radio"> <input checked="" type="radio" name="OrderForm[type_id]" value="1" id="customRadio1" tabindex="3"><label class="modal-radio" for="customRadio1"><span><?= Yii::t('app','payment-delivery')?></span></label></div>
                                        <div class="blank-slate p-4 text-center border-bottom">
                                            <?=$cont->about_title?>
                                        </div>
                                    </div>
                                    <div class="radio-wrap">
                                        <div class="radio"> <input type="radio" name="OrderForm[type_id]" value="2" id="customRadio2" tabindex="3"><label class="modal-radio" for="customRadio2"><span><?= Yii::t('app','payment-bank')?></span></label></div>
                                        <div class="blank-slate p-4 text-center ">
                                            <?=$cont->about_url?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6">
                                <a href="<?= Url::to(['shopping-cart']) ?>" class="btn">
                                    <i class="fas fa-angle-left"></i> <?= Yii::t('app', 'shopping-cart') ?>
                                </a>
                            </div>
                            <?php if (!empty($cart->getItems())){ ?>
                                <div class="form-group text-right col-6 mb-0">
                                    <?= Html::submitButton(Yii::t('app', 'shopping-order-submit'), ['class' => 'btn btn-submit btn-success']) ?>
                                </div>
                            <?php } ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                </div>

            </div>

            <div class="col-lg-6 pl-md-3 pl-lg-4">

                <div class="shopping-order-cart ">
                    <?php if (empty($cart->getItems())): ?>
                        <div class="empty-cart d-none d-lg-block mt-4 mt-lg-0">
                            <div class="alert alert-success text-center" role="alert">
                                <?= Yii::t('app', 'shopping-cart-empty') ?>
                            </div>
                        </div>

                        <div class="button-box text-center d-none d-lg-block">
                            <a href="<?= Url::to(['list-product','page'=>1]) ?>" class="btn btn-info">
                                <?= Yii::t('app', 'shopping-continue') ?>
                            </a>
                        </div>
                    <?php else : ?>
                        <table class="table_ordered mt-4 mt-lg-2">
                            <?php foreach ($cart->getItems() as $row) :
                                $product = $row->getProduct(); ?>
                                <tr >
                                    <td class="img-wrap">
                                        <span  class="img-box border rounded mb-3">
                                             <a href="<?= $product->getUrl() ?>" class="img d-flex ">
                                                 <img class="m-auto" src="<?= $product->getDefaultImg() ?>" alt="<?= $product->name ?>" title="<?= $product->name ?>" />
                                             </a>
                                        </span>

                                    </td>
                                    <td class="info">
                                        <h4 class="product-name mb-2"><a href="<?= $product->getUrl(); ?>"><?= $product->name; ?></a></h4>
                                        <div class="row no-gutters">
                                            <div class="col-6">
                                                <p class="mb-2"><?= MyExt::formatPrice($row->getPrice()) ?></p>
                                                <div class="input_cart mb-3 d-flex">
                                                    <button onclick="minusOrder(this,<?=$product->id?>,<?=$row->getPrice()?>)" class="btn-minus btn-cts" type="button">–</button>
                                                    <input type="text" name="quantity" id="qty" value="<?= $row->getQuantity() ?>" min="1" max="10">
                                                    <button onclick="plusOrder(this,<?=$product->id?>,<?=$row->getPrice()?>)" class="btn-plus btn-cts" type="button">+</button>
                                                </div>
                                            </div>
                                            <div class="col-6 text-right">
                                                <p class="red mb-2"><span class="mb-3 d-block total-price" data-num="<?=$row->getCost()?>"><?= MyExt::formatPrice($row->getCost()) ?></span></p>
                                                <a href="<?=Url::to(['site/removecart','id'=>$product->id])?>"><i class="far fa-trash-alt"></i></a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                        <div class="total-cart row no-gutters border-top pt-3">
                            <div class="col-7">
                                <?= Yii::t('app', 'shopping-total') ?>:
                            </div>
                            <div class="col-5 col-total red text-right">
                                <?= MyExt::formatPrice($cart->getTotalCost()) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>
</section>