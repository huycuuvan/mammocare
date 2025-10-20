<?php

namespace backend\models;

use Yii;
use backend\models\Desiredjob;
use backend\components\MyExt;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "profile".
 *
 * @property string $id
 * @property string $user_id
 * @property string $title tiêu đề
 * @property int $desired_job_id vị trí mong muốn
 * @property int $en_level_id trình độ tiếng anh
 * @property int $experience kinh nghiệm
 * @property int $wage_from lương từ
 * @property int $wage_to lương tới
 * @property string $objective mục tiêu công việc
 * @property string $self_description giới thiệu bản thân
 * @property int $company_type loại hình công ty
 * @property int $city tỉnh thành
 * @property string $height chiều cao
 * @property string $weight cân nặng
 * @property string $blood_type nhóm máu
 * @property string $cmnd CMND
 * @property string $cmnd_date ngày cấp CMND
 * @property string $course trường / khóa học
 * @property int $degree_id hệ đào tạo: đại học, cao đẳng, trung cấp, sơ cấp
 * @property int $graduated_year năm tốt nghiệp
 */
class Profile extends \yii\db\ActiveRecord
{
    use HasImgTrait;
    /**
     * {@inheritdoc}
     */
    const SCENARIO_CREATE='create_without_login';
    public $p_count;
    public $file,$title1;

    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','name', 'desired_job_id', 'title', 'address',  'birthday','lang_id'], 'required'],
            [['user_id', 'desired_job_id', 'en_level_id', 'experience', 'wage_from', 'wage_to', 'company_type', 'city', 'degree_id'], 'integer'],
            [['objective', 'self_description', 'graduated_year'], 'string'],
            [['title', 'height', 'weight', 'blood_type', 'cmnd', 'cmnd_date','cmnd_place'], 'string', 'max' => 200],
            [['course'], 'string', 'max' => 500],

            [['name', 'address', 'phone', 'info_city'], 'required', 'on' => self::SCENARIO_CREATE],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,gif,PNG,JPG,GIF,jpeg,JPEG,webp,WEBP','checkExtensionByMimeType' => false],
            [['name', 'path', 'phone'], 'string', 'max' => 200],
            [['address'], 'string', 'max' => 500],
            [['cmnd', 'cmnd_date','cmnd_place','birthday','sex','active','home','ord'], 'safe'],
            [['home','ord'], 'default', 'value'=> 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Kinh nghiệm',
            'desired_job_id' => 'Chức danh',
            'en_level_id' => 'Trình độ tiếng Anh',
            'experience' => 'Kinh nghiệm',
            'wage_from' => 'Lương',
            'wage_to' => 'Lương',
            'self_description' => 'Giới thiệu',
            'company_type' => 'Loại hình công ty',
            'city' => 'Tỉnh/Thành phố',
            'blood_type' => 'Nhóm máu',
            'cmnd' => 'Số CMND',
            'cmnd_date' => 'Ngày cấp CMND',
            'cmnd_place' => 'Nơi cấp CMND',
            'degree_id' => 'Hệ đào tạo',

            'course' => 'Chủ tàu 1',
            'objective' => 'Chủ tàu 2',
            'graduated_year' => 'Chủ tàu 3',
            'height' => 'Chủ tàu 4',
            'weight' => 'Chủ tàu 5',

            'name' => 'Họ tên',
            'path' => 'Path',
            'address' => 'Địa chỉ',
            'phone' => 'Điện thoại',
            'birthday' => 'Ngày sinh',
            'sex' => 'Hôn nhân',
            'info_city' => 'Tỉnh/Thành phố',
            'position' => 'Position',

            'active'=>'Hiển thị',
            'home'=>'Trang chủ',
            'ord'=>'Thứ tự',
            'lang_id'=>'Ngôn ngữ'
        ];
    }

    public function getCat()
    {
        return $this->hasOne(CatProfile::className(), ['id' => 'desired_job_id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }
    public static function getByPositionAndCount()
    {
        return Yii::$app->db
//            ->createCommand('SELECT *,count(*) as p_count FROM `profile` INNER JOIN `info` ON profile.user_id=info.user_id GROUP By desired_job_id ORDER BY p_count desc;')
            ->createCommand('SELECT *,count(*) as p_count FROM `profile` where active=1 GROUP By desired_job_id ORDER BY p_count desc;')
            ->queryAll();
    }

    public function getUrl()
    {
        $name=$this->name;
        return Url::toRoute(['site/view-profile', 'id' => $this->id, 'name' => MyExt::removeSign($name)]);
    }
    public function getViewUrl()
    {
        $name=$this->name;
        return Url::toRoute(['site/view-profile', 'id' => $this->id, 'name' => MyExt::removeSign($name)]);
    }
    public static function returnName($id){
        $find=Profile::find()->where(['id'=>$id])->one();
        $name='Chưa có';
        if(!empty($find)){
            if($find->user_id==0){
                $name=$find->name;
            }
            else{
                if($find->info) $name=$find->info->name;
            }
        }
        return $name;
    }
    public static function returnAddress($id){
        $find=Profile::find()->where(['id'=>$id])->one();
        $name='';
        if(!empty($find)){
            if($find->user_id==0){
                $name=$find->address;
            }
            else{
                if($find->info) $name=$find->info->address;
            }
        }
        return $name;
    }
    public static function returnImg($id){
        $find=Profile::find()->where(['id'=>$id])->one();
        $name='upload/no-image.png';
        if(!empty($find)){
            if($find->user_id==0){
                $name=$find->path;
            }
            else{
                if($find->info){
                    if($find->info->path) $name=$find->info->path;
                }
                if($find->path!='')
                    $name=$find->path;
            }
        }
        return $name;
    }
    public static function getNewProfile(){
        return Profile::find()->orderBy('id desc')->limit(12)->all();
    }
    public function getRelated()
    {
        $conf = Configure::getConfigure();
//        var_dump($jobs_position);
        return Profile::find()
            ->where('active = 1')
            ->andWhere(['<>','id',$this->id])
            ->andWhere(['in','desired_job_id',$this->desired_job_id])
            ->limit(6)
            ->orderBy(new Expression('rand()'))
            ->all();
    }

    public static function getHomeProject($limit = 0, $feature = 0)
    {
        $conf = Configure::getConfigure();
        $model = Profile::find()
            ->where(['{{profile}}.active' => 1, '{{profile}}.home' => 1, '{{language}}.code' => Yii::$app->language])
            ->joinWith(['language'])
            ->orderBy(['{{profile}}.ord' => SORT_ASC, '{{profile}}.id' => SORT_DESC])
            ->limit(!empty($limit) ? $limit : $conf->home_prod_num)
            ->all();

        return $model;
    }

    public static function getHomeProjectwithCat($num = 20)
    {
        $check=0;
        $find_cat=CatProfile::find()->joinWith(['language'])->select('GROUP_CONCAT(cat_profile.id) as list_cat_home')->where(['home'=>1,'cat_profile.active'=>1, '{{language}}.code' => Yii::$app->language])->all();
        $string_cat='';
        if(!empty($find_cat)){
            if($find_cat[0]->list_cat_home!=NULL){
                $string_cat=$find_cat[0]->list_cat_home;
                $find_all_child=CatProfile::find()->select('GROUP_CONCAT(id) as list_cat_home')->where(['active'=>1])
                    ->andWhere(['in','parent',$string_cat])->all();
                if(!empty($find_all_child)){
                    if($find_all_child[0]->list_cat_home!=NULL){
                        $string_cat.=','.$find_all_child[0]->list_cat_home;
                    }
                }
            }
        }
        if($string_cat!=''){
            $find_Profile_home=Profile::find()->andWhere(['in','desired_job_id',$string_cat])->all();
            if(!empty($find_Profile_home)) $check=1;
        }
        return $check;
    }
}
