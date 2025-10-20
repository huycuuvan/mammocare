<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
/**
 * ContactForm is the model behind the contact form.
 */
class SubscribeForm extends Model
{
    const SCENARIO_ENQUIRY = 'enquiry';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_BOOK = 'book';
    const SCENARIO_BOOK2 = 'book2';
    public $name;
    public $email;
    public $phone;
    public $body;
    public $product;
    public $type;
    public $area;
    public $country;
    public $service;
    public $address;
    public $company,$select;
    public $cat,$date,$doctor,$time;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            // [['email', 'type'], 'required'],
            [['email', 'type','name','phone','company','body'], 'required', 'on' => self::SCENARIO_ENQUIRY,'message'=>Yii::t('app', 'messageerror')],
            [['name', 'email', 'phone'], 'required', 'on' => self::SCENARIO_REGISTER,'message'=>Yii::t('app', 'messageerror')],
            [['name',  'phone','body','cat','doctor','date','time'], 'required', 'on' => self::SCENARIO_BOOK,'message'=>Yii::t('app', 'messageerror')],
            [['name', 'phone', 'date' ], 'required', 'on' => self::SCENARIO_BOOK2,'message'=>Yii::t('app', 'messageerror')],
            // email has to be a valid email address
            ['email', 'email'],
            [['body', 'area', 'country', 'service', 'address', 'type'], 'string'],
            [['product'], 'integer'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
            [['company', 'select'], 'string', 'max' => 255]
            // verifyCode needs to be entered correctly
            // [['service', 'country'], 'required', 'on' => self::SCENARIO_ENQUIRY],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
          'name' => Yii::t('app', 'fullname'),
          'email' => Yii::t('app', 'email'),
          'phone' => Yii::t('app', 'phone'),
          'body' => Yii::t('app', 'message'),
          'product' => Yii::t('app', 'product'),
          'area' => Yii::t('app', 'area-code'),
          'service' => Yii::t('app', 'service-care'),
          'address' => Yii::t('app', 'address'),
          'country' => Yii::t('app', 'country'),
          'company' => Yii::t('app', 'subject'),
          'date' => 'Ngày',
        ];
    }
    public static function getCountry()
    {
      return ['Afghanistan','Albania','Algeria','Andorra','Angola','Antigua & Deps','Argentina','Armenia','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus','Belgium','Belize','Benin','Bhutan','Bolivia','Bosnia Herzegovina','Botswana','Brazil','Brunei','Bulgaria','Burkina','Burundi','Cambodia','Cameroon','Canada','Cape Verde','Central African Rep','Chad','Chile','China','Colombia','Comoros','Congo','Congo {Democratic Rep}','Costa Rica','Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica','Dominican Republic','East Timor','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Ethiopia','Fiji','Finland','France','Gabon','Gambia','Georgia','Germany','Ghana','Greece','Grenada','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti','Honduras','Hungary','Iceland','India','Indonesia','Iran','Iraq','Ireland {Republic}','Israel','Italy','Ivory Coast','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Korea North','Korea South','Kosovo','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania','Luxembourg','Macedonia','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Mauritania','Mauritius','Mexico','Micronesia','Moldova','Monaco','Mongolia','Montenegro','Morocco','Mozambique','Myanmar, {Burma}','Namibia','Nauru','Nepal','Netherlands','New Zealand','Nicaragua','Niger','Nigeria','Norway','Oman','Pakistan','Palau','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Poland','Portugal','Qatar','Romania','Russian Federation','Rwanda','St Kitts & Nevis','St Lucia','Saint Vincent & the Grenadines','Samoa','San Marino','Sao Tome & Principe','Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','South Sudan','Spain','Sri Lanka','Sudan','Suriname','Swaziland','Sweden','Switzerland','Syria','Taiwan','Tajikistan','Tanzania','Thailand','Togo','Tonga','Trinidad & Tobago','Tunisia','Turkey','Turkmenistan','Tuvalu','Uganda','Ukraine','United Arab Emirates','United Kingdom','United States','Uruguay','Uzbekistan','Vanuatu','Vatican City','Venezuela','Vietnam','Yemen','Zambia','Zimbabwe'];
    }
    public static function getCountryName($id)
    {
      $arr = self::getCountry();
      return $arr[$id];
    }
    // public function scenarios()
    // {
    //     return [
    //         self::SCENARIO_ENQUIRY => ['email', 'type'],
    //         self::SCENARIO_REGISTER => ['name', 'email', 'phone', 'body', 'type'],
    //     ];
    // }
}
