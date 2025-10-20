<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use backend\models\HasImgTrait;
use yii\helpers\Url;
use backend\components\MyExt;

/**
 * This is the model class for table "cat".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $path
 * @property string $description
 * @property int $ord
 * @property int $home
 * @property int $active
 * @property int $parent
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_keyword
 */
class Cat extends \yii\db\ActiveRecord
{
    public $file, $file2;
    public $thumb;
    public $list_cat_home;

    use HasImgTrait {
        upload as myUpload;
        delete as myDelete;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat';
    }

    public function behaviors()
    {
        return [
            'url' => [
                'class' => UrlBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lang_id'], 'required'],
            [['description', 'description2', 'seo_desc', 'seo_keyword','content'], 'string'],
            [['ord', 'home', 'active', 'parent', 'lang_id','hot'], 'integer'],
            [['name', 'url', 'path', 'path2', 'seo_title','brief'], 'string', 'max' => 200],
            [['parent','hot'], 'default', 'value'=> 0],
            [['file', 'file2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF','checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên danh mục',
            'url' => 'Đường dẫn',
            'path' => 'Ảnh',
            'path2' => 'Ảnh banner',
            'description' => 'Mô tả chân trang',
            'description2' => 'Mô tả đầu trang',
            'ord' => 'Thứ tự',
            'home' => 'Trang chủ',
            'active' => 'Hiển thị',
            'parent' => 'Danh mục cha',
            'seo_title' => 'Tiêu đề SEO',
            'seo_desc' => 'Mô tả SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'thumb' => 'Ảnh',
            'lang_id' => 'Ngôn ngữ',
            'content'=>'Mô tả',
            'brief'=>'Mô tả ngắn ',
            'hot'=>'Nổi bật'
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->seo_title)
            $this->seo_title = $this->name;

        if (!$this->seo_desc)
            $this->seo_desc = (!$this->description) ? $this->name : substr(strip_tags($this->description), 0, 320);

        return parent::beforeSave($insert);
    }

    public function getFather()
    {
        return $this->hasOne(Cat::className(), ['id' => 'parent']);
    }

    public function getChild()
    {
        return $this->hasMany(Cat::className(), ['parent' => 'id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public static function getParent()
    {
        return Cat::find()
            ->where(['{{cat}}.active' => 1, 'parent' => 0,  '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    public static function getParentDDL()
    {
        $arr = [];
        $model = Cat::getParent();
        if (isset($model)) {
            foreach ($model as $row) {
                $arr[$row->id] = $row->name;
                $sub = $row->getSubCat();
                if (isset($sub)) {
                    foreach ($sub as $item) {
                        $arr[$item->id] = '|----'.$item->name;
                    }
                }
            }
        }

        return $arr;
    }

    public function getSubCat()
    {
        return Cat::find()
            ->where(['active' => 1, 'parent' => $this->id])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    /*--------Quản lý menu trong quản trị*/
    public static function getAdmin()
    {
        return Cat::find()
            ->where(['parent' => 0, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    //lay danh muc con theo danh muc cha
    public function getSubAdmin()
    {
        return Cat::find()
            ->where(['parent' => $this->id])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    //lay danh muc con trang chủ theo danh muc cha
    public function getSubAdminHome()
    {
        return Cat::find()
            ->where(['parent' => $this->id,'home'=>1])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    public static function getHome()
    {
        return Cat::find()
            ->where(['{{cat}}.active' => 1, '{{cat}}.home' => 1,  '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    public static function getHomeParent()
    {
        return Cat::find()
            ->where(['{{cat}}.active' => 1,'parent'=>0, '{{cat}}.home' => 1,  '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }

    public static function getHot()
    {
        return Cat::find()
            ->where(['{{cat}}.active' => 1, '{{cat}}.hot' => 1,  '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    public  function getCount()
    {
        $conf = Configure::getConfigure();
        $cat = Cat::findOne($this->id);

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
            ->select('product.id')
            ->where(['{{product}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere('category_id in ('. implode(',', $arr_subcat).')')
            ->orderBy(['{{product}}.id' => SORT_DESC])
            ->joinWith(['language'])
            ->count();
        return $model;
    }
    public function getHomeProductByCat($num=20)
    {
        $conf = Configure::getConfigure();
        $cat = Cat::findOne($this->id);
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
            ->where(['{{product}}.active' => 1, '{{product}}.home' => 1,  '{{language}}.code' => Yii::$app->language])
            ->andWhere('category_id in ('. implode(',', $arr_subcat).')')
            // ->orderBy(['{{product}}.ord' => SORT_ASC,'{{product}}.id' => SORT_DESC])
            ->orderBy(new \yii\db\Expression('{{product}}.ord IS NULL ASC, {{product}}.ord asc, {{product}}.id desc'))
//            ->limit($num)
            ->limit($conf->home_prod_num)
            ->joinWith(['language'])
            ->all();
        return $model;
    }

    public function getHotProductByCat($num=20)
    {
        $conf = Configure::getConfigure();
        $cat = Cat::findOne($this->id);
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
            ->where(['{{product}}.active' => 1, '{{product}}.hot' => 1,  '{{language}}.code' => Yii::$app->language])
            ->andWhere('category_id in ('. implode(',', $arr_subcat).')')
            // ->orderBy(['{{product}}.ord' => SORT_ASC,'{{product}}.id' => SORT_DESC])
            ->orderBy(new \yii\db\Expression('{{product}}.ord IS NULL ASC, {{product}}.ord asc, {{product}}.id desc'))
            ->limit($num)
            ->joinWith(['language'])
            ->all();
        return $model;
    }

    public function getBestProductByCat($num=20)
    {
        $conf = Configure::getConfigure();
        $cat = Cat::findOne($this->id);
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
            ->where(['{{product}}.active' => 1, '{{product}}.best' => 1,  '{{language}}.code' => Yii::$app->language])
            ->andWhere('category_id in ('. implode(',', $arr_subcat).')')
            // ->orderBy(['{{product}}.ord' => SORT_ASC,'{{product}}.id' => SORT_DESC])
            ->orderBy(new \yii\db\Expression('{{product}}.ord IS NULL ASC, {{product}}.ord asc, {{product}}.id desc'))
            ->limit($num)
            ->joinWith(['language'])
            ->all();
        return $model;
    }

    public function getHomeProductByCatHome($num=20)
    {
        $conf = Configure::getConfigure();
        $cat = Cat::findOne($this->id);
        $arr_subcat[]=$cat->id;
        $subcat=$cat->getSubAdminHome();
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
            ->where(['{{product}}.active' => 1, '{{product}}.home' => 1,  '{{language}}.code' => Yii::$app->language])
            ->andWhere('category_id in ('. implode(',', $arr_subcat).')')
            ->orderBy(['{{product}}.ord' => SORT_ASC,'{{product}}.id' => SORT_DESC])
            ->limit($conf->home_prod_num)
            ->joinWith(['language'])
            ->all();
        return $model;
    }
    public function getHomeProductByCatHomeNotParent($num=20)
    {
        $conf = Configure::getConfigure();
        $cat = Cat::findOne($this->id);
        $subcat=$cat->getSubAdminHome();
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
        if(!empty($arr_subcat))
            $model = Product::find()
                ->where(['{{product}}.active' => 1, '{{product}}.home' => 1,  '{{language}}.code' => Yii::$app->language])
                ->andWhere('category_id in ('. implode(',', $arr_subcat).')')
                ->orderBy(['{{product}}.ord' => SORT_ASC,'{{product}}.id' => SORT_DESC])
                ->limit($conf->home_prod_num)
                ->joinWith(['language'])
                ->all();
        return $model;
    }


    public static function getCatDDL()
    {
        $arr = [];
        $all_cat = Cat::getParent();
        if (!empty($all_cat)) {
            foreach ($all_cat as $row) {
                $arr[$row->id] = $row->name;
                $sub_cat = $row->getSubAdmin();
                if (!empty($sub_cat)) {
                    foreach ($sub_cat as $item) {
                        $arr[$item->id] = '|---' . $item->name;
                        $sub_cat1 = $item->getChild()
                            ->where(['active' => 1])
                            ->orderBy(['ord' => 'ASC', 'id' => 'DESC'])
                            ->all();
                        if (!empty($sub_cat1)) {
                            foreach ($sub_cat1 as $item1) {
                                $arr[$item1->id] = '|------' . $item1->name;
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }

    public function getUrl()
    {
        return Url::toRoute(['site/list-product', 'id' => $this->id, 'name' => $this->url,'page'=>1]);
    }


    public function upload()
    {
        $this->myUpload();

        if ($this->validate()) {

            if (!empty($this->file2->name)) {

                if (!empty($this->path2)) {
                    $path = Yii::getAlias('@root').'/'.$this->path2;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $folder = Yii::getAlias('@root') . '/';
                $filePath = 'upload/' . $this::tableName() . '/' . MyExt::removeSign($this->file2->baseName) . '.' . $this->file2->extension;

                $this->file2->saveAs($folder . $filePath, false);

                $this->path2 = $filePath;
            }

            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        if (!empty($this->path2))
            $this->deleteImg($this->path2);

        return $this->myDelete();
    }
    public static function getCatoption($selected=0)
    {

        $string='<option value="0">Tất cả</option>';
        $parent = Cat::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (!empty($parent)) {
            foreach ($parent as $item) {
                $string.='<option '.($item->id==$selected?'selected':'').' value="'.$item->id.'">'.$item->name.'</div>';
            }
        }
        echo $string;
    }

}
