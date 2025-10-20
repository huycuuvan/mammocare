<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $fullname
 * @property string $email
 * @property string $mobile
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property string $login_date
 * @property int $active
 * @property string $tasks
 * @property int $roles_id
 */
 class User extends ActiveRecord implements IdentityInterface
 {

     const STATUS_DELETED = 0;
     const STATUS_ACTIVE = 1;

     public $old_password;
     public $new_password;
     public $retype_password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
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
             [['username', 'password_hash', 'auth_key', 'fullname', 'email', 'created_at', 'roles_id'], 'required'],
             [['created_at', 'updated_at', 'login_date'], 'safe'],
             [['active', 'roles_id'], 'integer'],
             [['username', 'password_hash', 'password_reset_token', 'auth_key', 'email', 'address'], 'string', 'max' => 200],
             [['fullname', 'mobile'], 'string', 'max' => 50],
             ['password_hash', 'string', 'min' => 6],
             [['retype_password'], 'required', 'on' => 'create'],
             [['old_password', 'new_password', 'retype_password'], 'required', 'on' => 'change'],
             ['retype_password', 'compare', 'compareAttribute'=>'password_hash', 'skipOnEmpty' => false, 'message'=>"2 mật khẩu không trùng khớp!", 'on' => 'create'],
             ['retype_password', 'compare', 'compareAttribute'=>'new_password', 'skipOnEmpty' => false, 'message'=>"2 mật khẩu không trùng khớp!", 'on' => 'change'],
             ['old_password', function ($attribute, $params, $validator) {
                 if (!$this->validatePassword($this->$attribute)) {
                     $this->addError($attribute, 'Mật khẩu cũ không đúng!');
                 }
             }],
             ['active', 'default', 'value' => self::STATUS_ACTIVE],
             ['active', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
             [['fullname', 'address', 'address_number', 'store', 'country', 'district', 'city', 'ico', 'province', 'dic', 'psc', 'note'], 'string', 'max' => 255],
         ];
     }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'username' => 'Tài khoản',
            'password_hash' => 'Mật khẩu',
            'password_reset_token' => 'Khóa Reset',
            'auth_key' => 'Auth Key',
            'fullname' => 'Họ tên',
            'email' => 'Email',
            'mobile' => 'Di động',
            'address' => 'Địa chỉ',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'login_date' => 'Ngày đăng nhập',
            'active' => 'Kích hoạt',
            'roles_id' => 'Vai trò',
            'retype_password' => 'Nhập lại mật khẩu',
            'old_password' => 'Mật khẩu cũ',
            'new_password' => 'Mật khẩu mới',
            'address_number' => 'Số nhà',
            'country' => 'Quốc gia',
            'store' => 'Tên cửa hàng',
            'district' => 'Phố',
            'city' => 'Tỉnh',
            'ico' => 'Số IČO',
            'province' => 'Thành phố',
            'dic' => 'Số DIČ',
            'psc' => 'Số PSČ',
            'phone' => 'Điện thoại',
            'note' => 'Ghi chú',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'active' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'active' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'active' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function setRetypePassword($password)
    {
        $this->retype_password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getRoles()
    {
        return $this->hasOne(Roles::className(), ['id' => 'roles_id']);
    }

    public function getCreatedRolesDDL()
    {
      if (!empty(Yii::$app->user->identity->roles->roles_list)) {
        return ArrayHelper::map(Roles::find()->where('active = 1 AND id IN ('.Yii::$app->user->identity->roles->roles_list.')')->asArray()->all(), 'id', 'name');
      } else {
        return [];
      }
    }
}
