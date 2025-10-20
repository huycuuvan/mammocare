<?php
namespace backend\models;
use Yii;
use yii\behaviors\TimestampBehavior;
use backend\components\UrlBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use backend\models\CatNews;
use backend\models\HasImgTrait;
use yii\helpers\Url;
use backend\components\MyExt;
/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $path
 * @property string $url
 * @property string $brief
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property int $hot
 * @property int $home
 * @property int $active
 * @property int $hits
 * @property string $tags
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_desc
 * @property int $cat_id
 */
class News extends \yii\db\ActiveRecord
{
    public $file;
    public $cat_name;
    public $cat_url;
    public $thumb;
    public $doc;
    public $del_doc;
    use HasImgTrait {
        upload as myUpload;
        delete as myDelete;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }
    public function behaviors()
    {
        return [
            'url' => [
                'class' => UrlBehavior::className(),
                'byValue' => 'title'
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
            [['title', 'content', 'cat_id', 'lang_id'], 'required'],
            [['brief', 'content', 'tags', 'seo_keyword', 'seo_desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['hot', 'home', 'active', 'hits', 'cat_id', 'del_doc', 'lang_id'], 'integer'],
            [['title', 'path', 'path_file', 'url', 'seo_title'], 'string', 'max' => 200],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF,jpeg,JPEG,webp,WEBP','checkExtensionByMimeType' => false],
            [['doc'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc,DOC,docx,DOCX,pdf,PDF,xls,XLS,xlsx,XLSX','checkExtensionByMimeType' => false],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'title' => 'Tiêu đề',
            'path' => 'Ảnh',
            'path_file' => 'Tệp tin',
            'url' => 'Đường dẫn',
            'brief' => 'Tóm tắt',
            'content' => 'Chi tiết',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Cập nhật',
            'hot' => 'Nổi bật',
            'home' => 'Trang chủ',
            'active' => 'Hiển thị',
            'hits' => 'Lượt xem',
            'tags' => 'Tags',
            'seo_title' => 'Tiêu đề SEO',
            'seo_desc' => 'Mô tả SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'cat_id' => 'Danh mục',
            'file' => 'Chọn ảnh',
            'thumb' => 'Ảnh',
            'del_doc' => 'Xóa tệp tin',
            'lang_id' => 'Ngôn ngữ'
        ];
    }
    public function beforeSave($insert)
    {
        if (!$this->seo_title)
            $this->seo_title = $this->title;
        if (!$this->seo_desc)
            $this->seo_desc = ($this->brief) ? strip_tags($this->brief) : substr(strip_tags($this->content), 0, 320);
        return parent::beforeSave($insert);
    }
    public function getFather()
    {
        return $this->hasOne(CatNews::className(), ['id' => 'cat_id']);
    }
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
    public static function getHomeNews()
    {
        $conf = Configure::getConfigure();
        return News::find()
            ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where(['{{news}}.active' => 1, '{{news}}.home' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['father','language'])
            ->limit($conf->home_news_num)
            ->orderBy(['created_at'=>SORT_DESC, 'id' => SORT_DESC])
            ->all();
    }
    public static function getHotNews($limit = 4)
    {
        $conf = Configure::getConfigure();
        return News::find()
            ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where(['{{news}}.active' => 1, '{{news}}.hot' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['father','language'])
            ->limit($conf->latest_news_num)
            ->orderBy(['created_at'=>SORT_DESC, 'id' => SORT_DESC])
            ->all();
    }
    public function getRelatedNews()
    {
        $conf = Configure::getConfigure();
        return News::find()
            ->select(['{{news}}.*', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where('{{news}}.active = 1 AND {{news}}.id != '.$this->id.' AND {{news}}.cat_id = '.$this->cat_id.' AND {{language}}.code = "'.Yii::$app->language.'"')
            ->joinWith(['father','language'])
            ->limit($conf->hot_news_num)
            ->orderBy(['created_at'=>SORT_DESC, 'id' => SORT_DESC])
            ->all();
    }
    public static function countNews()
    {
        return Yii::$app->db
            ->createCommand('SELECT count(*) FROM news AS n INNER JOIN language AS l ON `n`.`lang_id` = `l`.`id` WHERE `l`.`code` = "'.Yii::$app->language.'"')
            ->queryScalar();
    }
    public static function getLatestFive()
    {
        $conf = Configure::getConfigure();
        return News::find()
            ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where(['{{news}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['father','language'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($conf->latest_news_num)
            ->all();
    }
    public static function getHitstFive()
    {
        $conf = Configure::getConfigure();
        return News::find()
            ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where(['{{news}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['father','language'])
            ->orderBy(['hits' => SORT_DESC])
            ->limit($conf->latest_news_num)
            ->all();
    }
    public static function getNewsByCat($catId, $limit = 5)
    {
        return News::find()
            ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where(['{{news}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['in', '{{news}}.cat_id', [$catId]])
            ->joinWith(['father','language'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit)
            ->all();
    }
    public static function getHomeNewsByCat($catId, $limit = 5)
    {
        $conf = Configure::getConfigure();
        $cat = CatNews::findOne($catId);
        $arrCat = [];
        if (!empty($cat)) {
            $arrCat[] = $cat->id;
            foreach ($cat->getSubAdmin() as $row) {
                $arrCat[] = $row->id;
            }
        }
        return News::find()
            ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where(['{{news}}.active' => 1, '{{news}}.home' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['in', '{{news}}.cat_id', $arrCat])
            ->joinWith(['father','language'])
            ->orderBy(['created_at'=>SORT_DESC,'id' => SORT_DESC])
            ->limit($conf->home_news_num)
            ->all();
    }
    public static function getHomeNewsByCatNotParent($catId, $limit = 5)
    {
        $conf = Configure::getConfigure();
        $cat = CatNews::findOne($catId);
        $arrCat = [];
        if (!empty($cat)) {
            foreach ($cat->getSubAdmin() as $row) {
                $arrCat[] = $row->id;
            }
        }
        return News::find()
            ->select(['{{news}}.*', 'REPLACE({{news}}.path, "/'.parent::tableName().'/", "/'.parent::tableName().'/thumb/") AS thumb', '{{cat_news}}.name AS cat_name', '{{cat_news}}.url AS cat_url'])
            ->where(['{{news}}.active' => 1, '{{news}}.home' => 1, '{{language}}.code' => Yii::$app->language])
            ->andWhere(['in', '{{news}}.cat_id', $arrCat])
            ->joinWith(['father','language'])
            ->orderBy(['created_at'=>SORT_DESC,'id' => SORT_DESC])
            ->limit($conf->latest_news_num)
            ->all();
    }
    public function getUrl()
    {
        // return Url::toRoute(['site/news', 'id' => $this->id, 'name' => $this->url, 'cat' => $this->father->url]);
        return Url::toRoute(['site/news', 'id' => $this->id, 'name' => $this->url]);
    }
    public function upload()
    {
        $this->myUpload();
        if ($this->validate()) {
            if (!empty($this->doc->name)) {
                if (!empty($this->path_file)) {
                    $path = Yii::getAlias('@root').'/'.$this->path_file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $folder = Yii::getAlias('@root') . '/';
                $filePath = 'upload/' . $this::tableName() . '/' . MyExt::removeSign($this->doc->baseName) . '.' . $this->doc->extension;
                $this->doc->saveAs($folder . $filePath, false);
                $this->path_file = $filePath;
            }
            else {
                if (!empty($this->del_doc)) {
                    if (!empty($this->path_file)) {
                        $path = Yii::getAlias('@root').'/'.$this->path_file;
                        if (file_exists($path)) {
                            unlink($path);
                        }
                        $this->path_file = '';
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
    public function delete()
    {
        if (!empty($this->path_file))
            $this->deleteImg($this->path_file);
        return $this->myDelete();
    }
}
