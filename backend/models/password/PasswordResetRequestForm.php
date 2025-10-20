<?php
namespace backend\models\password;

use Yii;
use yii\base\Model;
use backend\models\User;
use backend\models\SendMail;
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
                'targetClass' => '\backend\models\User',
                'filter' => ['active' => User::STATUS_ACTIVE],
                'message' => 'Không có tài khoản nào sử dụng email này'
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

        $link = MyExt::getDomain().Url::to(['site/reset-password', 'token' => $user->password_reset_token]);
        $content = Message::getMessage(Message::RESET_PASSWORD, [
            '{$username}' => $user->username,
            '{$link}' => '<a href="'.$link.'">'.$link.'</a>'
        ]);

        $mail = new SendMail;
        $mail->subject = $content['title'];
        $mail->content = $content['content'];
        $mail->email_list = $this->email;

        return $mail->send();
    }
}
