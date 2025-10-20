<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $body;
    public $verifyCode;
    public $capcha;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'phone'], 'required','message'=>Yii::t('app', 'messageerror')],
            // email has to be a valid email address
            ['email', 'email'],
            [['body'], 'string'],
//            ['verifyCode', 'captcha'],
            [['name', 'email', 'subject', 'phone'], 'string', 'max' => 255],
            // verifyCode needs to be entered correctly

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
          'subject' => Yii::t('app', 'subject'),
          'body' => Yii::t('app', 'message'),
          'verifyCode' => 'Mã xác nhận',
//          'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
