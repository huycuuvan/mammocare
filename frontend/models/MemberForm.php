<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\User;
use backend\components\MyExt;
use backend\models\Message;

/**
 * Member form
 */
class MemberForm extends Model
{
    const SCENARIO_INFO = 'info';
    const SCENARIO_PASS = 'change-pass';

    public $username;
    public $email;
    public $fullname;
    public $mobile;
    public $address;

    public $old_password;
    public $password;
    public $password_repeat;
    public $password_hash;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            [['username', 'fullname', 'mobile', 'address'], 'string', 'max' => 255],
            [['fullname'], 'required'],

            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_hash', 'string'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('app', 'member-err-password') ],
            ['old_password', function ($attribute, $params, $validator) {
                if (!$this->validatePassword($this->$attribute)) {
                    $this->addError($attribute, Yii::t('app', 'member-old-pass-err'));
                }
            }],
        ];
    }

    public function scenarios()
    {
       return [
           self::SCENARIO_INFO => ['username', 'fullname', 'mobile', 'address'],
           self::SCENARIO_PASS => ['old_password', 'password', 'password_repeat'],
       ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
          'username' => Yii::t('app', 'username'),
          'fullname' => Yii::t('app', 'fullname'),
          'email' => Yii::t('app', 'email'),
          'mobile' => Yii::t('app', 'phone'),
          'address' => Yii::t('app', 'address'),

          'old_password' => Yii::t('app', 'old_password'),
          'password' => Yii::t('app', 'password'),
          'password_repeat' => Yii::t('app', 'password-confirm'),
        ];
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

}
