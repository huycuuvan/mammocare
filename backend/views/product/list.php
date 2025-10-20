<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Product;
use backend\models\PropertyPrice;
use backend\models\PropertyProduct;
use backend\models\Attachment;
use backend\models\Property;
use backend\models\PropertyValue;
use backend\models\PropertyCat;
use backend\components\MyExt;
use yii\helpers\Url;
use backend\models\Language;

/* @var $this yii\web\View */
/* @var $model backend\models\Brand */
/* @var $form yii\widgets\ActiveForm */
//echo ($property_list);
$tmp=explode('/',$property_list);
$stt=1;
if(!empty($tmp)){
    $arr=[];
    $arr_check=[];
    for($i=0;$i<(count($tmp)-1);$i++){
        $tmp1=explode('-',$tmp[$i]);
        if(!empty($tmp1)){
            array_push($arr,explode(',',$tmp1[1]));
        }
    }

    $list= MyExt::combinations(array_filter($arr));
    if(!empty($list)){
        foreach ($list as $item){
            $c=0;
            $item=array_filter($item);
            array_push($arr_check,implode('-',$item));
            $find_product=PropertyPrice::find()->where(['product_id'=>$product_id,'property_string'=>implode('-',$item)])->one();
            $price=0;
            if(!empty($find_product))
                $price=$find_product->price;
            ?>
            <div class="row alert p-1 alert-info property-value-option" data-id="<?=implode('-',$item)?>">
                <?php
                echo '<strong>'.$stt.'.</strong>';
                foreach ($item as $a){
                    if($a!='') {
                        $f_a = PropertyValue::findOne($a);
                        if(!empty($f_a)){
                            if ($f_a->property) {
                                ?>
                                <div class="col-lg">
                                    <b><?= $f_a->property->name ?> </b>
                                    <p><?= $f_a->name ?></p>
                                </div>
                                <?php
                                $c++;
                            }
                        }
                    }
                }
                ?>
                <div class="col-lg-3 price">
                    <label class="mb-0" style="font-weight: 700" for="property-price-${child_item.id}">Giá: </label>
                    <input type="number" data-content="<?= Url::toRoute(['product/save-price-property']) ?>" data-id="<?=implode('-',$item)?>" data-num="<?=$product_id?>" id="property-price-" onblur="changepropertyprice(this)" onClick="this.select();" class="change-property-price form-control form-control-sm disabled" value="<?=$price?>">
                </div>
            </div>
            <?php
            $stt++;
        }
    }
}
?>
<span id="arr_check" data-content="<?=implode(',',$arr_check)?>"></span>
