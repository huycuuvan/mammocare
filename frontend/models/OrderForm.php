<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class OrderForm extends Model
{
    public $fullname;
    public $email;
    public $phone;
    public $address;
    public $content;
    public $type_id;
    public $province,$district,$ward;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['fullname','email', 'address', 'phone','type_id','province','district','ward'], 'required','message'=>'Hãy nhập thông tin'],
            // email has to be a valid email address
            ['email', 'email','message'=>'Định dạng email không đúng'],
            [['content'], 'string'],
            [['fullname', 'email', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
          'fullname' => Yii::t('app', 'fullname'),
          'address' => Yii::t('app', 'address'),
          'email' => Yii::t('app', 'email'),
          'phone' => Yii::t('app', 'phone'),
          'content' => Yii::t('app', 'message'),
          'province' => 'Tỉnh thành',
          'district' => 'Quận huyện',
          'ward' => 'Phường xã',
        ];
    }

}
