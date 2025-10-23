<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use backend\models\ContactCustomer;
use backend\components\MyExt;

/**
 * BookingForm is the model behind the booking form.
 */
class BookingForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $service_id;
    public $doctor_id;
    public $branch;
    public $preferred_date;
    public $preferred_time;
    public $message;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'service_id', 'branch', 'preferred_date', 'preferred_time'], 'required'],
            [['name', 'phone', 'email', 'branch', 'preferred_date', 'preferred_time', 'message'], 'string'],
            [['service_id', 'doctor_id'], 'integer'],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^[0-9\-\+\(\)\s]+$/', 'message' => 'Số điện thoại không hợp lệ'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'service_id' => 'Dịch vụ',
            'doctor_id' => 'Bác sĩ',
            'branch' => 'Chi nhánh',
            'preferred_date' => 'Ngày khám mong muốn',
            'preferred_time' => 'Giờ khám mong muốn',
            'message' => 'Ghi chú thêm',
        ];
    }

    /**
     * Sends an email with the booking information
     * @return bool whether the email was sent
     */
    public function sendBookingEmail()
    {
        if ($this->validate()) {
            $subject = 'Đặt lịch khám mới - ' . $this->name;
            $content = $this->getEmailContent();
            
            // Gửi email
            if (MyExt::sendMail(Yii::$app->params['adminEmail'], $subject, $content)) {
                // Lưu vào database
                $this->saveToDatabase();
                return true;
            }
        }
        return false;
    }

    /**
     * Lưu thông tin đặt lịch vào database
     */
    public function saveToDatabase()
    {
        $contact = new ContactCustomer();
        $contact->name = $this->name;
        $contact->mobile = $this->phone;
        $contact->email = $this->email;
        $contact->title = 'Đặt lịch khám - ' . $this->getServiceName();
        $contact->content = $this->getBookingContent();
        $contact->created_at = date('Y-m-d H:i:s');
        
        if ($contact->validate()) {
            $contact->save();
        }
    }

    /**
     * Lấy tên dịch vụ
     */
    public function getServiceName()
    {
        if ($this->service_id) {
            $service = \backend\models\Product::findOne($this->service_id);
            return $service ? $service->name : 'Dịch vụ khám';
        }
        return 'Dịch vụ khám';
    }

    /**
     * Lấy tên bác sĩ
     */
    public function getDoctorName()
    {
        if ($this->doctor_id) {
            $doctor = \backend\models\Supporter::findOne($this->doctor_id);
            return $doctor ? $doctor->name : 'Bác sĩ bất kỳ';
        }
        return 'Bác sĩ bất kỳ';
    }

    /**
     * Nội dung email
     */
    public function getEmailContent()
    {
        $content = '<h2>Thông tin đặt lịch khám mới</h2>';
        $content .= '<p><strong>Họ tên:</strong> ' . $this->name . '</p>';
        $content .= '<p><strong>Số điện thoại:</strong> ' . $this->phone . '</p>';
        $content .= '<p><strong>Email:</strong> ' . $this->email . '</p>';
        $content .= '<p><strong>Dịch vụ:</strong> ' . $this->getServiceName() . '</p>';
        $content .= '<p><strong>Bác sĩ:</strong> ' . $this->getDoctorName() . '</p>';
        $content .= '<p><strong>Chi nhánh:</strong> ' . $this->branch . '</p>';
        $content .= '<p><strong>Ngày khám:</strong> ' . $this->preferred_date . '</p>';
        $content .= '<p><strong>Giờ khám:</strong> ' . $this->preferred_time . '</p>';
        if ($this->message) {
            $content .= '<p><strong>Ghi chú:</strong> ' . $this->message . '</p>';
        }
        return $content;
    }

    /**
     * Nội dung lưu database
     */
    public function getBookingContent()
    {
        $content = "Dịch vụ: " . $this->getServiceName() . "\n";
        $content .= "Bác sĩ: " . $this->getDoctorName() . "\n";
        $content .= "Chi nhánh: " . $this->branch . "\n";
        $content .= "Ngày khám: " . $this->preferred_date . "\n";
        $content .= "Giờ khám: " . $this->preferred_time . "\n";
        if ($this->message) {
            $content .= "Ghi chú: " . $this->message;
        }
        return $content;
    }
}
