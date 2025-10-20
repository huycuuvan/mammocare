<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\User;
use backend\components\MyExt;
use backend\models\Message;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const MEMBER_ROLES_ID = 4;

    public $username;
    public $email;
    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'member-err-username')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('app', 'member-err-email')],

            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('app', 'member-err-password') ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
          'fullname' => Yii::t('app', 'username'),
          'email' => Yii::t('app', 'email'),
          'password' => Yii::t('app', 'password'),
          'password_repeat' => Yii::t('app', 'password-confirm'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->roles_id = 4;

        $this->sendEmail($user);
        $user->save();

        return $user;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
      $msg = Message::getMessage(Message::ACTIVE_ACCOUNT, [
        '{link}' => Url::toRoute(['site/active-account', 'token' => $user->verification_token], true)
      ]);

      return MyExt::sendMail($this->email, $msg['title'], $msg['content']);;
    }
}
