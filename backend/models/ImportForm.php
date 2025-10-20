<?php
namespace backend\models;
use Yii;
use yii\base\Model;
/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ImportForm extends Model
{
    public $file;
    public $email;
    public $address;
    public $mobile;
    public $body;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx'],
        ];
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'file'=>'Chọn tệp'
        );
    }
    public function upload()
    {
        if ($this->validate()) {

            if (!empty($this->file->name)) {

//                if (!empty($this->path_file)) {
//                    $path = Yii::getAlias('@root').'/'.$this->path_file;
//                    if (file_exists($path)) {
//                        unlink($path);
//                    }
//                }
                $folder = Yii::getAlias('@root') . '/';
                $filePath = 'upload/' . $this::tableName() . '/' . MyExt::removeSign($this->doc->baseName) . '.' . $this->doc->extension;

                $this->doc->saveAs($folder . $filePath, false);

                $this->path_file = $filePath;
            }
            return true;

        } else {
            return false;
        }
    }
}