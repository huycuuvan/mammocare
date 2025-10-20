<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\components\UrlBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\db\Query;
use backend\models\CatProduct;
use yii\helpers\Url;
use backend\models\PropertyProduct;
use backend\models\PropertyCat;
use backend\components\MyExt;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $brand_id brand id
 * @property string $name tên sản phẩm
 * @property string $url Đường dẫn
 * @property string $path
 * @property string $code mã sản phẩm
 * @property string $brief
 * @property string $description mô tả
 * @property int $retail giá niêm yết
 * @property int $sale giảm giá
 * @property int $status Tình trạng: coming soon, mới, second hand
 * @property int $ord
 * @property int $home
 * @property int $hot
 * @property int $hits lượt xem
 * @property int $active kích hoạt
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_desc
 */
class Product extends \yii\db\ActiveRecord
{
    public $pid;
    public $cat_id;
    public $property_value;
    public $property_price;
    public $property_list_item;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public function behaviors()
    {
        return [
            'url' => [
                'class' => UrlBehavior::className(),
            ],
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression("NOW()"),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'path', 'user_id', 'category_id', 'lang_id'], 'required'],
            [['user_id', 'retail', 'sale', 'status', 'ord', 'home', 'hot', 'hits', 'active', 'pid', 'category_id', 'lang_id', 'best'], 'integer'],
            [[ 'brief', 'description', 'seo_keyword', 'seo_desc', 'tags', 'property_value'], 'string'],
            [['description2', 'description3', 'description4', 'description5', 'description6','property_list_item'], 'string'],
            [['name', 'url', 'path', 'seo_title', 'news_ids'], 'string', 'max' => 255],
            [['brand_id','property', 'cat_id', 'created_at', 'updated_at','c_new','c_best','feature'], 'safe'],
            [['code'], 'string', 'max' => 50],
            [['best','status','place_id'], 'default', 'value' => 0],
//            [['code'], 'unique','on'=>'create']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'brand_id' => 'Tiện ích',
            'user_id' => 'Người tạo',
            'path' => 'Ảnh',
            'name' => 'Tiêu đề',
            'url' => 'Đường dẫn',
            'code' => 'Mã sản phẩm',
            'brief' => 'Tóm tắt',
            'description' => 'Chi tiết',
            'description2' => 'Số lượng sỉ',
            'description3' => 'Order Sold',
            'description4' => 'Bản đồ',
            'description5' => 'Đơn vị',
            'description6' => 'Lắp đặt',
            'retail' => 'Giá gốc',
            'sale' => 'Giá',
            'status' => 'Tình trạng',
            'ord' => 'Thứ tự',
            'home' => 'Trang chủ',
            'hot' => 'Nổi bật',
            'hits' => 'Lượt xem',
            'active' => 'Hiển thị',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Cập nhật',
            'seo_title' => 'Tiêu đề SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'seo_desc' => 'Mô tả SEO',
            'pid' => 'Mã sản phẩm',
            'tags' => 'Tags',
            'news_ids' => 'Tin tức',
            'cat_id' => 'Danh mục',
            'place_id' => 'Địa điểm',
            'category_id' => 'Danh mục chính',
            'lang_id' => 'Ngôn ngữ',
            'best' => 'Hot',
            'c_new' => 'Mới cập nhật',
            'c_best' => 'Bán chạy',
            'feature'=>'Hot Icon'
        ];
    }

    /*
     * Viết lại delete function của Product class
     * Xóa tất cả các ảnh của sản phẩm này
     */
    public function delete()
    {
        $imgs = $this->imgs;
        if (!empty($imgs)) {
            foreach ($imgs as $row) {
                $row->delete();
            }
        }


        foreach ($this->catProduct as $row) {
            $row->delete();
        }

        foreach ($this->properties as $row) {
            $row->delete();
        }
        foreach ($this->propertiesprice as $row) {
            $row->delete();
        }
        foreach ($this->brands as $row) {
            $row->delete();
        }


        return parent::delete();
    }

    /*
     * Đặt mảng các cat_id đã được lưu vào thuộc tính cat_id của sản phẩm
     */
    public static function populateRecord($record, $row)
    {
        parent::populateRecord($record, $row);
        $record->cat_id = $record->getExistedCatId();
        $record->brand_id = $record->getExistedBrandId();
        $record->property = $record->getPropertyList();
    }

    /*
     * Lấy ra mảng tất cả các danh mục mà sản phẩm này có trong bảng cat_product
     */
    public function getExistedCatId()
    {
        return Yii::$app->db->createCommand('SELECT DISTINCT cat_id FROM cat_product WHERE product_id = ' . $this->id)->queryColumn();
    }
    public function getExistedBrandId()
    {
        return Yii::$app->db->createCommand('SELECT DISTINCT brand_id FROM cat_brand WHERE product_id = ' . $this->id)->queryColumn();
    }


    public function getPropertyList()
    {
        $propertyList = [];

        $propertyObj = PropertyProduct::getPropertyByProduct($this->id);

        foreach ($propertyObj as $row) {
            $propertyList[$row->property_id][] = $row->property_value_id;
        }

        return $propertyList;
    }


    /*
     * Sau khi lưu thì kiểm tra xem nếu có danh mục mới được chọn thì thêm vào
     * Nếu có danh mục bị xóa thì xóa khỏi CSDL
     */
    public function afterSave($insert, $changedAttributes)
    {
        $existed_cat = $this->getExistedCatId();

//        if (is_array($this->cat_id))
//            $this->cat_id = array_merge($this->cat_id, [$this->category_id]);
//        else
        $this->cat_id = [$this->category_id];


        foreach ($this->cat_id as $val) {
            if (empty($existed_cat) || !in_array($val, $existed_cat)) {
                $model = new CatProduct;
                $model->cat_id = $val;
                $model->product_id = $this->id;
                $model->save();
            }
        }

        if (isset($existed_cat)) {
            $delete_cat = [];
            foreach ($existed_cat as $val) {
                if (!in_array($val, $this->cat_id))
                    $delete_cat[] = $val;
            }
            if (!empty($delete_cat)) {
                Yii::$app->db->createCommand()->delete('cat_product', 'cat_id IN (' . implode(',', $delete_cat) . ') AND product_id = ' . $this->id)->execute();
            }
        }

        //Property handling
        $propertyList = $this->getPropertyList();
        $propertyExists = [];
        if($this->property)
            foreach ($this->property as $property => $arrValue) {

                if (is_array($arrValue)) {
                    foreach ($arrValue as $value) {
                        //khi có chọn thuộc tính theo danh mục
//                        $f=PropertyCat::find()->where(['property_id'=>$property,'cat_id'=>$this->category_id])->all();
//                        if(!empty($f)){
//                            if (empty($propertyList[$property]) || !in_array($value, $propertyList[$property])) {
//                                $model = new PropertyProduct;
//                                $model->property_id = $property;
//                                $model->product_id = $this->id;
//                                $model->property_value_id = $value;
//                                $model->save();
//                            }
//
//                            $propertyExists[$property][] = $value;
//                        }

//                        khi không chọn thuộc tính theo danh mục
                        if (empty($propertyList[$property]) || !in_array($value, $propertyList[$property])) {
                            $model = new PropertyProduct;
                            $model->property_id = $property;
                            $model->product_id = $this->id;
                            $model->property_value_id = $value;
                            $model->save();
                        }

                        $propertyExists[$property][] = $value;

                    }
                }
            }

        //Delete if not exists
        $propertyObj = PropertyProduct::getPropertyByProduct($this->id);
        if($propertyObj)
            foreach ($propertyObj as $row) {
                if (empty($propertyExists[$row->property_id]) || !in_array($row->property_value_id, $propertyExists[$row->property_id])) {
                    $row->delete();
                }
            }

//        var_dump($this->property_list_item);
        //xử lý xóa các giá của property đã bị xóa
        if(!empty($this->property_list_item)){
            $tmp=explode('/',$this->property_list_item);
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
                        $find=PropertyPrice::find()->where(['product_id'=>$this->id,'property_string'=>implode('-',$item)])->one();
                        if(!empty($find))
                            array_push($arr_check,$find->id);

                    }
                }
//                var_dump($arr_check);
                if(!empty($arr_check))
                    PropertyPrice::deleteAll('id not in('.implode(',',$arr_check).') and product_id='.$this->id);
                else
                    PropertyPrice::deleteAll('product_id='.$this->id);
            }
        }

     //======xử lý tiện ích=======================================
        $existed_brand = $this->getExistedBrandId();

        if (is_array($this->brand_id)){
            $this->brand_id = array_merge($this->brand_id);
            foreach ($this->brand_id as $val) {
                if (empty($existed_brand) || !in_array($val, $existed_brand)) {
                    $model = new CatBrand();
                    $model->brand_id = $val;
                    $model->product_id = $this->id;
                    $model->save();
                }
            }
        }

        if (isset($existed_brand)) {
            $delete_brand = [];
            foreach ($existed_brand as $val) {
                if(is_array($this->brand_id)){
                    if (!in_array($val, $this->brand_id))
                        $delete_brand[] = $val;
                }
                else{
                    $delete_brand[] = $val;
                }

            }
            if (!empty($delete_brand)) {
                Yii::$app->db->createCommand()->delete('cat_brand', 'brand_id IN (' . implode(',', $delete_brand) . ') AND product_id = ' . $this->id)->execute();
            }
        }

        //======xử lý seo=======================================
        if($this->seo_desc==''){
            $seo_desc=MyExt::getBlock(strip_tags($this->description),300);
            Yii::$app->db->createCommand()->update('product',['seo_desc'=>$seo_desc], 'id = ' . $this->id)->execute();

        }
        parent::afterSave($insert, $changedAttributes);
    }

    /*
     * Trước khi lưu thì lấy thông tin từ tiêu đề, mô tả khởi tạo thông tin SEO
     */
    public function beforeSave($insert)
    {
        if (!$this->seo_title) {
            $this->seo_title = $this->name;
        }

        if (!$this->seo_desc) {
            $this->seo_desc = substr(strip_tags($this->brief), 0, 320);
        }
//xử lý xóa các giá của property đã bị xóa
        if(!empty($this->property_list_item)){
            $tmp=explode('/',$this->property_list_item);
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
                        $find=PropertyPrice::find()->where(['product_id'=>$this->pid,'property_string'=>implode('-',$item)])->one();
                        if(!empty($find))
                            array_push($arr_check,$find->id);

                    }
                }
//                var_dump($arr_check);
                if(!empty($arr_check))
                    PropertyPrice::deleteAll('id not in('.implode(',',$arr_check).') and product_id='.$this->pid);
                else
                    PropertyPrice::deleteAll('product_id='.$this->pid);
            }
        }
        return parent::beforeSave($insert);
    }

    public function getProperty()
    {
        return unserialize($this->property_value);
    }

    public function setProperty($value)
    {
        $this->property_value = serialize($value);
    }

    public function getProperties()
    {
        return $this->hasMany(PropertyProduct::className(), ['product_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }
    public function getPropertiesprice()
    {
        return $this->hasMany(PropertyPrice::className(), ['product_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }
    public function getBrands()
    {
        return $this->hasMany(CatBrand::className(), ['brand_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    public function getOptions()
    {
//        return $this->hasMany(PropertyProduct::className(), ['product_id' => 'id'])->onCondition(['active' => 1])->orderBy(['id' => SORT_ASC]);
//        return $this->hasMany(PropertyProduct::className(), ['product_id' => 'id'])->orderBy(['id' => SORT_ASC]);
        $propertyList = [];

        $propertyObj = PropertyProduct::getPropertyByProduct($this->id);
        return $propertyObj;
    }

    public function getImgs()
    {
        if (empty($this->id))
            return Attachment::getImgsAlone();

        return $this->hasMany(Attachment::className(), ['pid' => 'id'])->orderBy(['ord' => SORT_ASC, 'id' => SORT_ASC]);
    }
    public function getAllbrands()
    {
        return $this->hasMany(CatBrand::className(), ['product_id' => 'id'])->orderBy([ 'id' => SORT_ASC]);
    }
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public function getCat()
    {
        return $this->hasOne(Cat::className(), ['id' => 'cat_id']);
    }


    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
    public function getPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'place_id']);
    }


    public function getPropertyProduct()
    {
        return $this->hasMany(PropertyProduct::className(), ['product_id' => 'id']);
    }


    public function getCatProduct()
    {
        return $this->hasMany(CatProduct::className(), ['product_id' => 'id']);
    }
    public static function getUnit()
    {
        return [
            1=>'Giờ',
            2=>'Ngày'
        ];
    }

    public static function getUnitName($pos)
    {
        if($pos){
            $posName = self::getUnit();
            return $posName[$pos];
        }
        else
            return '';

    }
    public static function countProduct()
    {
        return Yii::$app->db
            ->createCommand('SELECT count(*) FROM product AS n INNER JOIN language AS l ON `n`.`lang_id` = `l`.`id` WHERE `l`.`code` = "' . Yii::$app->language . '"')
            ->queryScalar();
    }

    public static function getHome()
    {
        return Product::find()
            ->where(['{{product}}.active' => 1, '{{product}}.home' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
    public static function getHomeProduct($num = 20)
    {
        $conf = Configure::getConfigure();
        $model = Product::find()
            ->where(['{{product}}.active' => 1, '{{product}}.home' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['{{product}}.ord' => SORT_ASC, '{{product}}.id' => SORT_DESC])
            ->limit($conf->home_prod_num)
            ->all();

        return $model;
    }
    public static function getHot()
    {
        $conf = Configure::getConfigure();
        return Product::find()
            ->where(['{{product}}.active' => 1, '{{product}}.hot' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->limit($conf->hot_prod_num)
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
    public static function getBest()
    {
        $conf = Configure::getConfigure();
        return Product::find()
            ->where(['{{product}}.active' => 1, '{{product}}.best' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->limit($conf->hot_prod_num)
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }

    public static function getLatestFive()
    {
        return Product::find()
            ->where(['{{product}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['id' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    public function getOtherProduct($num = 12)
    {
        $conf = Configure::getConfigure();
        $cat=Cat::findOne($this->cat_id);
        $arr_subcat[]=$cat->id;
        $subcat=$cat->getSubAdmin();
        if (!empty($subcat)){
            foreach ($subcat as $row) {
                $arr_subcat[] = $row->id;
                $subcat1=$row->getSubAdmin();
                if (!empty($subcat1)){
                    foreach ($subcat1 as $row1) {
                        $arr_subcat[] = $row1->id;
                    }
                }
            }
        }

        $model = Product::find()
            ->where(['{{product}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['<>', '{{product}}.id', $this->id])
            ->andWhere(['in', '{{cat_product}}.cat_id', $arr_subcat])
            ->joinWith(['language', 'catProduct'])
            ->orderBy(['{{product}}.id' => SORT_DESC])
            ->limit($conf->orther_prod_num)
            ->all();

        return $model;
    }

    public function getOtherCatProduct($num = 12)
    {
        $conf = Configure::getConfigure();
        $model = Product::find()
            ->where(['{{product}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['<>', '{{product}}.id', $this->id])
            ->andWhere(['{{product}}.category_id' => $this->category_id])
            ->joinWith(['language'])
            ->orderBy(['{{product}}.id' => SORT_DESC])
            ->limit($conf->orther_prod_num)
            ->all();

        return $model;
    }
    public function getAllProductByCat($cat_id,$num = 5)
    {
        $conf = Configure::getConfigure();
        $model = Product::find()
            ->where(['{{product}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['<>', '{{product}}.id', $this->id])
            ->andWhere(['{{product}}.category_id' => $this->category_id])
            ->joinWith(['language'])
            ->orderBy(['{{product}}.id' => SORT_DESC])
            ->limit($num)
            ->all();

        return $model;
    }

    public function getUrl()
    {
        return Url::to(['site/product', 'id' => $this->id, 'name' => $this->url],true);
    }

    public function getDefaultImg()
    {
        return $this->path ? $this->path : 'css/images/noimage.jpg';
    }

    public function getDefaultFullImg()
    {
        return $this->path ? str_replace('/thumb', '', $this->path) : 'css/images/noimage.jpg';
    }

    public function getCategory()
    {
        return $this->hasOne(Cat::className(), ['id' => 'category_id']);
    }

    public function getProductCat()
    {
        return Cat::findOne($this->category_id);
    }

    public function getProductImgs()
    {
        return Attachment::find()->where(['pid' => $this->id])->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->all();
    }

    public function getPropertyJson()
    {
        $arr = [];

        $property_father = Property::getProperty();

        if (isset($property_father)) {
            foreach ($property_father as $row) {
                $propertyObj = PropertyProduct::find()->where(['property_id' => $row->id, 'product_id' => $this->id])->all();
                $arr2 = [];
                if (isset($propertyObj)) {
                    foreach ($propertyObj as $row2) {
                        $arr2[] = [
                            "id" => $row2->id,
                            "name" => PropertyValue::getPropertyName($row2->property_value_id),
                            "path" => $row2->attachment_id ? Attachment::getPathById($row2->attachment_id) : 'upload/choose_img.jpg',
                            'price' => $row2->property_price,
                            'active' => $row2->active
                        ];
                    }
                }
                $arr[] = [
                    "id" => $row->id,
                    "name" => $row->name,
                    "child" => $arr2,
                ];
            }
        }

        return $arr;
    }
    public static function getCnew($catId=0)
    {
        $conf = Configure::getConfigure();
        if($catId==0)
            return Product::find()
                ->where(['{{product}}.active' => 1, '{{product}}.c_new' => 1, '{{language}}.code' => Yii::$app->language])
                ->joinWith(['language', 'catProduct'])
                ->limit(10)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        else{
            $cat = Cat::findOne($catId);
            $arr_subcat[]=$catId;
            $subcat=$cat->getSubAdmin();
            if (!empty($subcat)){
                foreach ($subcat as $row) {
                    $arr_subcat[] = $row->id;
                    $subcat1=$row->getSubAdmin();
                    if (!empty($subcat1)){
                        foreach ($subcat1 as $row1) {
                            $arr_subcat[] = $row1->id;
                        }
                    }
                }
            }

            return Product::find()
                ->where(['{{product}}.active' => 1, '{{product}}.c_new' => 1, '{{language}}.code' => Yii::$app->language])
                ->joinWith(['language', 'catProduct'])
                ->andWhere(['in', '{{cat_product}}.cat_id', $arr_subcat])
                ->limit(10)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }
    }
    public static function getCbest($catId=0)
    {
        $conf = Configure::getConfigure();
        if($catId==0)
            return Product::find()
                ->where(['{{product}}.active' => 1, '{{product}}.c_best' => 1, '{{language}}.code' => Yii::$app->language])
                ->joinWith(['language', 'catProduct'])
                ->limit(10)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        else{
            $cat = Cat::findOne($catId);
            $arr_subcat[]=$catId;
            $subcat=$cat->getSubAdmin();
            if (!empty($subcat)){
                foreach ($subcat as $row) {
                    $arr_subcat[] = $row->id;
                    $subcat1=$row->getSubAdmin();
                    if (!empty($subcat1)){
                        foreach ($subcat1 as $row1) {
                            $arr_subcat[] = $row1->id;
                        }
                    }
                }
            }

            return Product::find()
                ->where(['{{product}}.active' => 1, '{{product}}.c_best' => 1, '{{language}}.code' => Yii::$app->language])
                ->joinWith(['language', 'catProduct'])
                ->andWhere(['in', '{{cat_product}}.cat_id', $arr_subcat])
                ->limit(10)
                ->orderBy(['id' => SORT_DESC])
                ->all();
        }
    }
    public static function countbyprovince($province)
    {
        return Yii::$app->db
            ->createCommand('SELECT count(*) FROM product AS n INNER JOIN language AS l ON `n`.`lang_id` = `l`.`id` WHERE `l`.`code` = "' . Yii::$app->language . '" and place_id='.$province.' and `n`.`active`=1')
            ->queryScalar();
    }
    public static function checkHomeProductwithCatHome(){
        $check=0;
        $find_cat=Cat::find()->select('GROUP_CONCAT(id) as list_cat_home')->where(['home'=>1,'active'=>1])->all();
        $string_cat='';
        if(!empty($find_cat)){
            if($find_cat[0]->list_cat_home!=NULL){
                $string_cat=$find_cat[0]->list_cat_home;
                $find_all_child=Cat::find()->select('GROUP_CONCAT(id) as list_cat_home')->where(['active'=>1])
                    ->andWhere(['in','parent',$string_cat])->all();
                if(!empty($find_all_child)){
                    if($find_all_child[0]->list_cat_home!=NULL){
                        $string_cat.=','.$find_all_child[0]->list_cat_home;
                    }
                }
            }
        }
        if($string_cat!=''){
            $find_product_home=Product::find()->andWhere(['in','category_id',$string_cat])->all();
            if(!empty($find_product_home)) $check=1;
        }
        return $check;
    }
    public static function getStatusName($status)
    {

        if($status){
            $posName = Yii::$app->params['status'];
            return $posName[$status];
        }
        else
            return '';
    }
}
