<?php
namespace backend\models;

use Yii;
use backend\components\MyExt;
use yii\imagine\Image;

trait HasImgTrait {

    /*
     * Image of tables will be saved into folder is named by table name.
     * $this::tableName() return every table name
     */
    public function delete()
    {
        if (!empty($this->path))
            $this->deleteImg($this->path);

        return parent::delete();
    }

    /*
     * Xóa hình ảnh được truyền vào qua tham số $path_url
     * Sử dụng khi 1 record có chứa ảnh bị xóa hoặc xóa ảnh đại diện của 1 tin tức
     */
    public function deleteImg($path_url)
    {
        $path = Yii::getAlias('@root').'/'.$path_url;
        $thumb_path = str_replace("/".$this::tableName()."/", "/".$this::tableName()."/thumb/", $path);

        /*----Xóa ảnh nhỏ----*/
        if (file_exists($thumb_path)) {
            unlink($thumb_path);
        }

        /*----Xóa ảnh lớn----*/
        if (file_exists($path)) {
            unlink($path);
        }
    }

    /*
     * Upload function send image to server
     */
    public function upload()
    {
        if ($this->validate()) {
            if (!empty($this->file->name)) {
                $conf = Configure::getConfigure();

                /*----Remove old images if existed----*/
                if (!empty($this->path)) {
                    $path = Yii::getAlias('@root').'/'.$this->path;
                    if (file_exists($path)) {
                        unlink($path);
                    }

                    $thumb = str_replace($this::tableName(), $this::tableName().'/thumb/',$path);
                    if (file_exists($thumb)) {
                        unlink($thumb);
                    }
                }

                /*----Create folder of image if it isn't existed----*/
                $folder = 'upload/'.$this::tableName().'/';
                if(!is_dir(Yii::getAlias('@root').'/'.$folder)) {
                    mkdir(Yii::getAlias('@root').'/'.$folder);
                }
                if(!is_dir(Yii::getAlias('@root').'/'.$folder.'thumb/')) {
                    mkdir(Yii::getAlias('@root').'/'.$folder.'thumb/');
                }

                $img_path = $folder.'thumb/'.rand(3, 9999).MyExt::removeSign($this->file->baseName).'.'.$this->file->extension;
                /*----Save orginal image----*/
                $this->file->saveAs(Yii::getAlias('@root').'/'.str_replace('thumb/','',$img_path), false);
                // Image::resize($this->file->tempName, $conf->max_width, $conf->max_height)
                // ->save(Yii::getAlias('@root').'/'.str_replace('thumb/','',$img_path), ['jpeg_quality' => 100]);

                /*----Save thumb image----*/
                Image::thumbnail($this->file->tempName, $conf->all_thumb_width, $conf->all_thumb_height)
                ->save(Yii::getAlias('@root').'/'.$img_path, ['jpeg_quality' => 100]);
                /*----Save image into database----*/
                $this->path = str_replace('thumb/','',$img_path);
            }
            return true;
        }
        return false;
    }
    public function uploadback()
    {
        if ($this->validate()) {
            if (!empty($this->img->name)) {

                /*----Remove old images if existed----*/
                if (!empty($this->background)) {
                    $path = Yii::getAlias('@root').'/'.$this->background;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                /*----Create folder of image if it isn't existed----*/
                $folder = 'upload/'.$this::tableName();
                if(!is_dir(Yii::getAlias('@root').'/'.$folder)) {
                    mkdir(Yii::getAlias('@root').'/'.$folder);
                }

                $img_path = $folder.'/'.rand(3, 9999).MyExt::removeSign($this->img->baseName).'.'.$this->img->extension;
                /*----Save orginal image----*/
                $this->img->saveAs(Yii::getAlias('@root').'/'.$img_path, false);
                /*----Save image into database----*/
                $this->background = $img_path;
            }
            return true;
        }
        return false;
    }
    public function uploadvideo()
    {
        if ($this->validate()) {

            if (!empty($this->doc->name)) {

                if (!empty($this->path_file)) {
                    $path = Yii::getAlias('@root').'/'.$this->path_file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                $folder = Yii::getAlias('@root') . '/';
                $filePath = 'upload/' . $this::tableName() . '/' . MyExt::removeSign($this->doc->baseName) . '.' . $this->doc->extension;

                $this->doc->saveAs($folder . $filePath, false);

                $this->path_file = $filePath;
            }
            else {
                if (!empty($this->del_doc)) {
                    if (!empty($this->path_file)) {
                        $path = Yii::getAlias('@root').'/'.$this->path_file;
                        if (file_exists($path)) {
                            unlink($path);
                        }

                        $this->path_file = '';
                    }
                }
            }

            return true;

        } else {
            return false;
        }
    }
}
?>
