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
            [['user_id', 'retail', 'sale', 'brand_id', 'status', 'ord', 'home', 'hot', 'hits', 'active', 'pid', 'category_id', 'lang_id', 'best', 'feature'], 'integer'],
            [['brief', 'description', 'seo_keyword', 'seo_desc', 'tags', 'property_value'], 'string'],
            [['description2', 'description3', 'description4', 'description5', 'description6'], 'string'],
            [['name', 'url', 'path', 'seo_title', 'news_ids'], 'string', 'max' => 255],
            [['property', 'cat_id', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 50],
            [['best'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'brand_id' => 'Thương hiệu',
            'user_id' => 'Người tạo',
            'path' => 'Ảnh',
            'name' => 'Tên sản phẩm',
            'url' => 'Đường dẫn',
            'code' => 'Video URL code',
            'brief' => 'Tóm tắt',
            'description' => 'Chi tiết sản phẩm',
            'description2' => 'Giá sỉ',
            'description3' => 'Tài liệu',
            'description4' => 'Số người',
            'description5' => 'Số giường',
            'description6' => 'Chứng nhận',
            'retail' => 'Giá gốc',
            'sale' => 'Giá bán',
            'status' => 'Tình trạng',
            'ord' => 'Thứ tự',
            'home' => 'Trang chủ',
            'hot' => 'Khuyến mại',
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
            'category_id' => 'Danh mục chính',
            'lang_id' => 'Ngôn ngữ',
            'best' => 'Bán chạy',
            'feature' => 'Nổi bật',
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


        return parent::delete();
    }

    /*
     * Đặt mảng các cat_id đã được lưu vào thuộc tính cat_id của sản phẩm
     */
    public static function populateRecord($record, $row)
    {
        parent::populateRecord($record, $row);
        $record->cat_id = $record->getExistedCatId();
        $record->property = $record->getPropertyList();
    }

    /*
     * Lấy ra mảng tất cả các danh mục mà sản phẩm này có trong bảng cat_product
     */
    public function getExistedCatId()
    {
        return Yii::$app->db->createCommand('SELECT DISTINCT cat_id FROM cat_product WHERE product_id = ' . $this->id)->queryColumn();
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

        if (is_array($this->cat_id))
            $this->cat_id = array_merge($this->cat_id, [$this->category_id]);
        else
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

        if (!empty($this->property)) {
            foreach ($this->property as $property => $arrValue) {

                if (is_array($arrValue)) {
                    foreach ($arrValue as $value) {
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
        }


        //Delete if not exists
        $propertyObj = PropertyProduct::getPropertyByProduct($this->id);
        foreach ($propertyObj as $row) {
            if (empty($propertyExists[$row->property_id]) || !in_array($row->property_value_id, $propertyExists[$row->property_id])) {
                $row->delete();
            }
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

    public function getOptions()
    {
        return $this->hasMany(PropertyProduct::className(), ['product_id' => 'id'])->onCondition(['active' => 1])->orderBy(['id' => SORT_ASC]);
    }

    public function getImgs()
    {
        if (empty($this->id))
            return Attachment::getImgsAlone();

        return $this->hasMany(Attachment::className(), ['pid' => 'id'])->orderBy(['ord' => SORT_ASC, 'id' => SORT_ASC]);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public function getCat()
    {
        return $this->hasOne(Cat::className(), ['id' => 'cat_id']);
    }


    public function getPropertyProduct()
    {
        return $this->hasMany(PropertyProduct::className(), ['product_id' => 'id']);
    }


    public function getCatProduct()
    {
        return $this->hasMany(CatProduct::className(), ['product_id' => 'id']);
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
    public static function getHomeProduct($limit = 0, $feature = 0)
    {
        $conf = Configure::getConfigure();
        $model = Product::find()
            ->where(['{{product}}.active' => 1, '{{product}}.home' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['{{product}}.feature' => $feature])
            ->joinWith(['language'])
            ->orderBy(['{{product}}.ord' => SORT_ASC, '{{product}}.id' => SORT_DESC])
            ->limit(!empty($limit) ? $limit : $conf->home_prod_num)
            ->all();

        return $model;
    }
    public static function getHot($limit = 0, $feature = 0)
    {
        $conf = Configure::getConfigure();
        return Product::find()
            ->where(['{{product}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['{{product}}.feature' => 1])
            ->joinWith(['language'])
            ->limit(!empty($limit) ? $limit : $conf->hot_prod_num)
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
    public static function getBest($limit = 0, $feature = 0)
    {
        $conf = Configure::getConfigure();
        return Product::find()
            ->where(['{{product}}.active' => 1, '{{product}}.best' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['{{product}}.feature' => $feature])
            ->joinWith(['language'])
            ->orderBy(['id' => SORT_DESC])
            ->limit(!empty($limit) ? $limit : $conf->hot_prod_num)
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
        $model = Product::find()
            ->where(['{{product}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['<>', '{{product}}.id', $this->id])
            ->joinWith(['language'])
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

    public function getUrl()
    {
        return Url::toRoute(['site/product', 'id' => $this->id, 'name' => $this->url]);
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
}
