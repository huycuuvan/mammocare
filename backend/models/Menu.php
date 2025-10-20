<?php
namespace backend\models;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\models\HasImgTrait;
/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name Menu name
 * @property int $position Vị trí hiển thị
 * @property string $type
 * @property string $link
 * @property int $parent
 * @property int $ord
 * @property int $new_tab
 * @property int $active
 * @property string $symbol
 * @property string $background
 */
class Menu extends \yii\db\ActiveRecord
{
    public $img;
    const MAIN_MENU = 1;
    const FOOTER_MENU = 2;
    const LEFT_MENU = 3;
    const TOP_MENU = 4;
    const BOTTOM_MENU = 5;
    use HasImgTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'position', 'type', 'lang_id'], 'required'],
            [['position', 'parent', 'ord', 'new_tab', 'active', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50],
            [['description'], 'string'],
            [['parent','full'], 'default', 'value'=> 0],
            [['link', 'symbol', 'background'], 'string', 'max' => 200],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF','checkExtensionByMimeType' => false],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Tên menu',
            'position' => 'Vị trí',
            'type' => 'Trang đích',
            'link' => 'Liên kết',
            'parent' => 'Menu cha',
            'ord' => 'Thứ tự',
            'new_tab' => 'Mở tab mới',
            'active' => 'Hiển thị',
            'symbol' => 'Biểu tượng',
            'background' => 'Màu nền',
            'lang_id' => 'Ngôn ngữ',
            'description'=>'Mô tả',
            'full'=>'Mở rộng',
        ];
    }
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
    //receive positions of category array
    public static function getPosition()
    {
        return [
            self::MAIN_MENU => 'Menu chính',
            self::FOOTER_MENU => 'Menu cuối trang',
            self::TOP_MENU => 'Menu Top',
//            self::LEFT_MENU => 'Menu danh mục',
//            self::BOTTOM_MENU => 'Menu chân trang',
        ];
    }
    //receive position name
    public static function getPositionName($pos)
    {
        $posName = self::getPosition();
        return $posName[$pos];
    }
    public static function getParentDDL($position)
    {
        $arr = [];
        $model = Menu::getMenu($position);
        if (isset($model)) {
            foreach ($model as $row) {
                $arr[$row->id] = $row->name;
                $sub = $row->getSubMenu();
                if (isset($sub)) {
                    foreach ($sub as $item) {
                        $arr[$item->id] = '|---'.$item->name;
                        $sub1 = $item->getSubMenu();
                        if (isset($sub1)) {
                            foreach ($sub1 as $item1) {
                                $arr[$item1->id] = '|------'.$item1->name;
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }
    //receive positions of category array
    public static function getMenu($pos)
    {
        return Menu::find()
        ->where(['{{menu}}.active' => 1, 'parent' => 0, 'position' => $pos, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    //lay danh muc con theo danh muc cha
    public function getSubMenu()
    {
        return Menu::find()
        ->where(['active' => 1, 'parent' => $this->id])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    public function getSubMenuHome()
    {
        return Menu::find()
            ->where(['active' => 1, 'parent' => $this->id])
            ->orderBy(['has_image'=>SORT_DESC, 'ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    public function getSubMenuHasimage()
    {
        return Menu::find()
            ->where(['active' => 1, 'parent' => $this->id,'has_image'=>1])
            ->orderBy([ 'ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    //receive positions of category array
    public static function getAdmin($pos)
    {
        return Menu::find()
            ->where(['parent' => 0, 'position' => $pos, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    //lay danh muc con theo danh muc cha
    public function getSubAdmin()
    {
        return Menu::find()
            ->where(['parent' => $this->id])
            ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    public static function getMenuDLL()
    {
        $arr  = [];
        $arr['0:0'] = 'Liên kết bên ngoài';
        //liên kết thông thường
        $arr['Liên kết thông thường'] = array();
        $arr['Liên kết thông thường']['1:1'] = '|--Trang chủ';
//        $arr['Liên kết thông thường']['1:3'] = '|--Sản phẩm';
//        $arr['Liên kết thông thường']['1:6'] = '|--Bác sĩ';
//        $arr['Liên kết thông thường']['1:7'] = '|--Hỏi đáp';
//        $arr['Liên kết thông thường']['1:8'] = '|--Thuyền viên';
        //trang nội dung
        $page = Page::getPage();
        if (!empty($page))
        {
            $arr['Trang nội dung'] = array();
            foreach ($page as $row) {
                $arr['Trang nội dung']['2:' . $row->id] = '|--' . $row->title;
            }
        }
        //danh mục nội dung
        $cat_news = CatNews::getCatNews();
        if (!empty($cat_news))
        {
            $arr['Danh mục bài viết'] = array();
            foreach ($cat_news as $row) {
                $arr['Danh mục bài viết']['3:' . $row->id] = '|--' . $row->name;
                $sub = $row->getSubAdmin();
                if (!empty($sub))
                {
                    foreach ($sub as $item) {
                        $arr['Danh mục bài viết']['3:' . $item->id]='|----' . $item->name;
                        $sub1 = $item->getSubAdmin();
                        foreach ($sub1 as $item1) {
                            $arr['Danh mục bài viết']['3:' . $item1->id]='|-------' . $item1->name;
                        }
                    }
                }
            }
        }
        /*
         * Nếu có danh mục sản phẩm thì mới hiển thị menu Sản phẩm
         * và hiển thị các liên kết danh mục
         */
        $cat_pro = Cat::getParent();
        if (!empty($cat_pro))
        {
            $arr['Danh mục sản phẩm'] = array();
            foreach ($cat_pro as $row) {
                $arr['Danh mục sản phẩm']['4:' . $row->id] = '|--' . $row->name;
                $sub = $row->getSubCat();
                if (!empty($sub))
                {
                    foreach ($sub as $item) {
                        $arr['Danh mục sản phẩm']['4:' . $item->id]='|----' . $item->name;
                    }
                }
            }
        }
        /*
         * Nếu có danh mục bác sĩ thì mới hiển thị menu Sản phẩm
         * và hiển thị các liên kết danh mục
         */
        $cat_pro = CatDoctor::getParent();
        if (!empty($cat_pro))
        {
            $arr['Danh mục chuyên khoa'] = array();
            foreach ($cat_pro as $row) {
                $arr['Danh mục chuyên khoa']['5:' . $row->id] = '|--' . $row->name;
            }
        }
        /*
         * Nếu có album ảnh thì mới hiển thị menu Thư viện ảnh
         */
        if (Album::find()->count() > 0) {
            $arr['Liên kết thông thường']['1:4'] = '|--Thư viện ảnh';
        }
        /*
         * Nếu có video thì mới hiển thị menu Thư viện video
         */
        if (Video::find()->count() > 0) {
            $arr['Liên kết thông thường']['1:5'] = '|--Thư viện video';
        }
        $arr['Liên kết thông thường']['1:2'] = '|--Liên hệ';
        return $arr;
    }
    public static function getPath($str)
    {
        $arr = explode(':', $str);
        if ($arr[0]==1)
        {
            switch ($arr[1]) {
                case 1:
                    return Yii::$app->urlManagerFrontend->baseUrl;
                    break;
                case 3:
                    return Yii::$app->urlManagerFrontend->createUrl(['site/list-product','page'=>1]);
                    break;
                case 4:
                    return Yii::$app->urlManagerFrontend->createUrl(['site/gallery','page'=>1]);
                    break;
                case 5:
                    return Yii::$app->urlManagerFrontend->createUrl(['site/video','page'=>1]);
                    break;
                case 6:
                    return Yii::$app->urlManagerFrontend->createUrl(['site/team','page'=>1]);
                    break;
                case 8:
                    return Yii::$app->urlManagerFrontend->createUrl(['site/list-profile','page'=>1]);
                    break;
                case 7:
                    return Yii::$app->urlManagerFrontend->createUrl(['site/faq']);
                    break;
                default:
                    return Yii::$app->urlManagerFrontend->createUrl('site/contact');
                    break;
            }
        }
        elseif ($arr[0]==2)
        {
            $model=Page::findOne($arr[1]);
            if (!empty($model))
                return Yii::$app->urlManagerFrontend->createUrl(['site/page', 'id' => $model->id, 'name' => $model->url]);
            else
                return '#';
        }
        elseif ($arr[0]==3)
        {
            $model=CatNews::findOne($arr[1]);
            if (!empty($model))
                return Yii::$app->urlManagerFrontend->createUrl(['site/list-news', 'id' => $model->id, 'name' => $model->url,'page'=>1]);
            else
                return '#';
        }
        elseif ($arr[0]==5)
        {
            $model=CatDoctor::findOne($arr[1]);
            if (!empty($model))
                return Yii::$app->urlManagerFrontend->createUrl(['site/list-doctor', 'id' => $model->id, 'name' => $model->url,'page'=>1]);
            else
                return '#';
        }
        else
        {
            $model=Cat::findOne($arr[1]);
            if (!empty($model))
                return Yii::$app->urlManagerFrontend->createUrl(['site/list-product', 'id' => $model->id, 'name' => $model->url,'page'=>1]);
            else
                return '#';
        }
    }
}
