<?php
namespace backend\models;
use yii\helpers\Url;
use backend\components\MyExt;
use Yii;
/**
 * This is the model class for table "supporter".
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string $facebook
 * @property int $ord
 * @property int $active
 */
class Supporter extends \yii\db\ActiveRecord
{
    public $file;
    use HasImgTrait;
    const TOP = 1;
    const BOTTOM = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supporter';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lang_id'], 'required'],
            [['ord', 'active', 'lang_id'], 'integer'],
            [['name', 'mobile', 'email', 'path', 'job','brief'], 'string', 'max' => 255],
            [['content','info1','info2'], 'string'],
            [['home'], 'default', 'value'=> 0],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'name' => 'Họ tên',
            'job' => 'Chuyên khoa',
            'brief'=>'Học hàm, học vị',
            'mobile' => 'Điện thoại',
            'email' => 'Email',
            'ord' => 'Thứ tự',
            'path' => 'Ảnh',
            'home' => 'T.Chủ',
            'content' => 'Mô tả ngắn',
            'active' => 'Hiển thị',
            'position' => 'Vị trí',
            'lang_id' => 'Ngôn ngữ',
            'info1' => 'Chứng chỉ',
            'info2' => 'Kinh nghiệm',
        ];
    }
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
    public function getFather()
    {
        return $this->hasOne(CatDoctor::className(), ['id' => 'job']);
    }
    public static function getSupport($pos=Supporter::TOP)
    {
        return Supporter::find()
        ->where(['{{supporter}}.active' => 1, 'position'=>$pos, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    public static function getSupportHome()
    {
        return Supporter::find()
        ->where(['{{supporter}}.active' => 1,'home'=>1,  '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    public static function getAllSupport()
    {
        return Supporter::find()
        ->where(['{{supporter}}.active' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])
        ->all();
    }
    public static function getPosition()
    {
        return [
            self::TOP => 'Top',
            self::BOTTOM => 'Hỗ trợ'
        ];
    }
    public function getUrl()
    {
        // return Url::toRoute(['site/news', 'id' => $this->id, 'name' => $this->url, 'cat' => $this->father->url]);
        return Url::toRoute(['site/detail', 'id' => $this->id, 'name' => MyExt::removeSign(trim($this->name))]);
    }
    public function getRelated()
    {
        $conf = Configure::getConfigure();
        return Supporter::find()
            ->select(['{{supporter}}.*', '{{cat_doctor}}.name AS cat_name', '{{cat_doctor}}.url AS cat_url'])
            ->where('{{supporter}}.active = 1 AND {{supporter}}.id != '.$this->id.' AND {{supporter}}.job = '.$this->job.' AND {{language}}.code = "'.Yii::$app->language.'"')
            ->joinWith(['father','language'])
            ->limit($conf->hot_news_num)
            ->orderBy(['{{supporter}}.ord'=>SORT_ASC, 'id' => SORT_DESC])
            ->all();
    }
    public static function getOption($cat_id,$selected=0)
    {
        $string='';
        $parent = Supporter::find()
            ->where(['job'=> $cat_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
        if (!empty($parent)) {
            foreach ($parent as $item) {
                $string.='<option '.($item->id==$selected?'selected':'').' value="'.$item->id.'">'.$item->name.'</div>';
            }
        }
        echo $string;
    }
    public static function getDoctor($cat_id)
    {
        return Supporter::find()
            ->where(['job' => $cat_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }
    public static function getDoctorDDL($cat_id)
    {
        $arr = [];
        $parent =Supporter::find()
            ->where(['job' => $cat_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
        if (!empty($parent)) {
            foreach ($parent as $item) {
                $arr[$item->id] = $item->name;
            }
        }
        return $arr;
    }
}
