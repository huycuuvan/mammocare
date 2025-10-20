<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use SimpleXMLElement;
use backend\models\Cat;
use backend\models\CatNews;
use backend\models\CatApp;
use backend\models\CatTemplate;
use backend\models\Product;
use backend\models\News;
use backend\models\Page;
use backend\models\Template;
use backend\models\App;
use backend\components\MyExt;

/**
 * Login form
 */
class CreateXml extends Model
{
    CONST NEWS_TBL = 0.9;
	CONST CATNEWS_TBL = 1;
	CONST CAT_TBL = 1;
	CONST PRODUCT_TBL = 0.9;
	CONST PAGE_TBL = 0.8;
	CONST ORTHER_TBL = 0.7;
	CONST CHANGE_TIME = 'monthly';

    public $sitemap = 'sitemap.xml';
    public $cssPath = 'css/customize.css';
    public $data = '';
    public $simpleXml = '';
    public $defaultXml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"></urlset>';

    public function init()
	{
        $sitemap_path = Yii::getAlias('@root').'/'.$this->sitemap;
        if (!file_exists($sitemap_path)) {
			$handle = fopen($sitemap_path, 'w') or die('Cannot open file: '.$sitemap_path);
			$this->data = $this->defaultXml;
		} else {
			$handle = fopen($sitemap_path, 'r') or die('Cannot open file: '.$sitemap_path);
			if (filesize($sitemap_path))
				$this->data = fread($handle, filesize($sitemap_path));
			else
				$this->data = $this->defaultXml;
		}

		$this->simpleXml = new SimpleXMLElement($this->data);
		fclose($handle);
    }

    public function add($data_item)
	{
		$item_url = $this->simpleXml->addChild('url');
		$item_url->addChild('loc', $data_item['loc']);
		$item_url->addChild('lastmod', $data_item['lastmod']);
		$item_url->addChild('changefreq', $data_item['changefreq']);
		$item_url->addChild('priority', $data_item['priority']);
		$this->data = $this->simpleXml->asXML();
		$this->save();
	}

	public function save()
	{
        $sitemap_path = Yii::getAlias('@root').'/'.$this->sitemap;
		$handle = fopen($sitemap_path, 'r+') or die('Cannot open file: '.$sitemap_path);
		ftruncate($handle, 0);
		fwrite($handle, $this->data);
		fclose($handle);
	}

	public function reset() {
        $sitemap_path = Yii::getAlias('@root').'/'.$this->sitemap;
        $domain = MyExt::getDomain();
		$handle = fopen($sitemap_path, 'r+') or die('Cannot open file: '.$sitemap_path);
		ftruncate($handle, 0);
		$this->data = $this->defaultXml;
		$this->simpleXml = new SimpleXMLElement($this->data);

		$lang = Language::getLanguageDDL();
        $langList = array_keys($lang);


		//Thêm danh sách liên kết bảng Cat
		$cat = Cat::find()->where(['active' => 1, 'lang_id' => $langList])->all();
		foreach ($cat as $row) {
			$item_url = $this->simpleXml->addChild('url');
			$item_url->addChild('loc', htmlspecialchars($domain.Yii::$app->urlManagerFrontend->createUrl(['site/list-product', 'id' => $row->id, 'name' => $row->url, 'page' => 1])));
			$item_url->addChild('lastmod', date('Y-m-d'));
			$item_url->addChild('changefreq', self::CHANGE_TIME);
			$item_url->addChild('priority', self::CAT_TBL);
		}

		//Thêm danh sách liên kết bảng Product
		$product = Product::find()->where(['active' => 1, 'lang_id' => $langList])->all();
		foreach ($product as $row) {
			$item_url = $this->simpleXml->addChild('url');
			$item_url->addChild('loc', htmlspecialchars($domain.Yii::$app->urlManagerFrontend->createUrl(["site/product", "id" => $row->id, "name" => $row->url])));
			$item_url->addChild('lastmod', date('Y-m-d'));
			$item_url->addChild('changefreq', self::CHANGE_TIME);
			$item_url->addChild('priority', self::PRODUCT_TBL);
		}

		//Thêm danh sách liên kết bảng CatNews
		$cat_news = CatNews::find()->where(['active' => 1, 'lang_id' => $langList])->all();
		foreach ($cat_news as $row) {
			$item_url = $this->simpleXml->addChild('url');
			$item_url->addChild('loc', htmlspecialchars($domain.Yii::$app->urlManagerFrontend->createUrl(['site/list-news', 'id' => $row->id, 'name' => $row->url,'page'=>1])));
			$item_url->addChild('lastmod', date('Y-m-d'));
			$item_url->addChild('changefreq', self::CHANGE_TIME);
			$item_url->addChild('priority', self::CATNEWS_TBL);
		}

		//Thêm danh sách liên kết bảng News
		$news = News::find()->where(['active' => 1, 'lang_id' => $langList])->all();
		foreach ($news as $row) {
			$item_url = $this->simpleXml->addChild('url');
			$item_url->addChild('loc', htmlspecialchars($domain.Yii::$app->urlManagerFrontend->createUrl(['site/news',  'id' => $row->id, 'name' => $row->url])));
			$item_url->addChild('lastmod', date('Y-m-d', strtotime($row->updated_at)));
			$item_url->addChild('changefreq', self::CHANGE_TIME);
			$item_url->addChild('priority', self::NEWS_TBL);
		}

		//Thêm danh sách liên kết bảng Page
		$page = Page::find()->where(['active' => 1, 'lang_id' => $langList])->all();
		foreach ($page as $row) {
			$item_url = $this->simpleXml->addChild('url');
			$item_url->addChild('loc', htmlspecialchars($domain.Yii::$app->urlManagerFrontend->createUrl(['site/page', 'id' => $row->id, 'name' => $row->url])));
			$item_url->addChild('lastmod', date('Y-m-d'));
			$item_url->addChild('changefreq', self::CHANGE_TIME);
			$item_url->addChild('priority', self::PAGE_TBL);
		}


        //Thêm danh sách liên kết bảng Cat
        $cat = CatProfile::find()->where(['active' => 1, 'lang_id' => $langList])->all();
        foreach ($cat as $row) {
            $item_url = $this->simpleXml->addChild('url');
            $item_url->addChild('loc', htmlspecialchars($domain.Yii::$app->urlManagerFrontend->createUrl(['site/list-profiles', 'id' => $row->id, 'name' => $row->url, 'page' => 1])));
            $item_url->addChild('lastmod', date('Y-m-d'));
            $item_url->addChild('changefreq', self::CHANGE_TIME);
            $item_url->addChild('priority', self::CAT_TBL);
        }

        //Thêm danh sách liên kết bảng Product
        $product = Profile::find()->where(['active' => 1, 'lang_id' => $langList])->all();
        foreach ($product as $row) {
            $item_url = $this->simpleXml->addChild('url');
            $item_url->addChild('loc', htmlspecialchars($domain.Yii::$app->urlManagerFrontend->createUrl(["site/view-profile", "id" => $row->id, "name" => MyExt::removeSign($row->name)])));
            $item_url->addChild('lastmod', date('Y-m-d'));
            $item_url->addChild('changefreq', self::CHANGE_TIME);
            $item_url->addChild('priority', self::PRODUCT_TBL);
        }



        $fixed_url = [Yii::$app->urlManagerFrontend->createUrl('site/contact')];
        $fixed_url = [Yii::$app->urlManagerFrontend->createUrl(['site/list-profile','page'=>1])];
        if (Product::find()->count() > 0)
            $fixed_url[] = Yii::$app->urlManagerFrontend->createUrl('site/all-product');

		if (Album::find()->count() > 0)
			$fixed_url[] = Yii::$app->urlManagerFrontend->createUrl(['site/gallery','page'=>1]);

		if (Video::find()->count() > 0)
			$fixed_url[] = Yii::$app->urlManagerFrontend->createUrl(['site/video','page'=>1]);

		if (!empty($fixed_url)) {
			foreach ($fixed_url as $val) {
				$item_url = $this->simpleXml->addChild('url');
				$item_url->addChild('loc', $domain.$val);
				$item_url->addChild('lastmod', date('Y-m-d'));
				$item_url->addChild('changefreq', self::CHANGE_TIME);
				$item_url->addChild('priority', self::ORTHER_TBL);
			}
		}

		$this->data = $this->simpleXml->asXML();
		fwrite($handle, $this->data);
		fclose($handle);
	}
}
