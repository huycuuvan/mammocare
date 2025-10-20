<?php

namespace backend\models;

use Yii;
use backend\components\UrlBehavior;
use yii\helpers\Url;
use PHPHtmlParser\Dom;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $content
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_keyword
 * @property int $active
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    public function behaviors()
    {
        return [
            'url' => [
                'class' => UrlBehavior::className(),
                'byValue' => 'title'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id', 'lang_id'], 'required'],
            [['content', 'seo_desc', 'seo_keyword'], 'string'],
            [['active', 'user_id', 'editor', 'lang_id'], 'integer'],
            [['title', 'url', 'seo_title'], 'string', 'max' => 200],
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
            'url' => 'Đường dẫn',
            'content' => 'Nội dung',
            'seo_title' => 'Tiêu đề SEO',
            'seo_desc' => 'Mô tả SEO',
            'seo_keyword' => 'Từ khóa SEO',
            'active' => 'Hiển thị',
            'user_id' => 'Người tạo',
            'lang_id' => 'Ngôn ngữ'
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->seo_title)
            $this->seo_title = $this->title;

        if (!$this->seo_desc)
            $this->seo_desc = substr(strip_tags($this->content), 0, 320);

        $dom = new Dom;
        $dom->loadStr($this->content);
        $imgs = $dom->find('img');
        
        $base64text = 'data:image';
        $savePath =  '/upload/cdn/images/';

        foreach ($imgs as $img) {
            if (substr($img->src, 0, strlen($base64text)) != $base64text) 
                continue;

            $filename = $img->{'data-filename'};

            
            $imgdata = preg_replace('|data:image/[^;]+;base64,|', '', $img->src);
            $imgdata = str_replace(' ', '+', $imgdata);
            // var_dump($imgdata);die();
            $data = base64_decode($imgdata);

            $srcfile = $savePath . $filename;

            file_put_contents('..' . $srcfile, $data);
            $img->setAttribute('src', Yii::$app->params['basePath'] . $srcfile);
        }

        $this->content = $dom;

        return parent::beforeSave($insert);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public static function getPage()
    {
        return Page::find()
        ->where(['{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['id' => SORT_DESC])
        ->all();
    }

    public static function countPage()
    {
        return Yii::$app->db
        ->createCommand('SELECT count(*) FROM page AS n INNER JOIN language AS l ON `n`.`lang_id` = `l`.`id` WHERE `l`.`code` = "'.Yii::$app->language.'"')
        ->queryScalar();
    }

    public static function getLatestFive()
    {
        return Page::find()
            ->where(['{{page}}.active' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['id' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    public function getUrl()
    {
        return Url::toRoute(['site/page', 'id' => $this->id, 'name' => $this->url]);
    }
}
