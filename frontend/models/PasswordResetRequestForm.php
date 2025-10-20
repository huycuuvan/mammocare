<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\Message;
use yii\helpers\Url;
use backend\components\MyExt;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['active' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'active' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $msg = Message::getMessage(Message::REQUEST_PASS, [
          '{link}' => Url::toRoute(['site/reset-password', 'token' => $user->password_reset_token], true)
        ]);

        return MyExt::sendMail($user->email, $msg['title'], $msg['content']);;
    }
}
