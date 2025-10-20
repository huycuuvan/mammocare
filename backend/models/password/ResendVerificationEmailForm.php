<?php
namespace backend\models\password;

use Yii;
use yii\base\Model;
use backend\models\User;
use backend\models\SendMail;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
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
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
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

         $mail = new SendMail;
         $mail->subject = 'Reset mật khẩu';
         $mail->content = 'Reset mật khẩu';
         $mail->email_list = $this->email;

         return $mail->send();
     }
}
