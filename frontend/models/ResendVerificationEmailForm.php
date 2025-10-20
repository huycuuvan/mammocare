<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\Message;
use yii\helpers\Url;
use backend\components\MyExt;

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
                'targetClass' => '\common\models\User',
                'filter' => ['active' => User::STATUS_INACTIVE],
                'message' => Yii::t('app', 'member-not-found')
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
      $user = User::findOne([
        'email' => $this->email,
        'active' => User::STATUS_INACTIVE
      ]);

      if ($user === null) {
        return false;
      }

      $msg = Message::getMessage(Message::ACTIVE_ACCOUNT, [
        '{link}' => Url::toRoute(['site/active-account', 'token' => $user->verification_token], true)
      ]);

      return MyExt::sendMail($user->email, $msg['title'], $msg['content']);;
    }
}
