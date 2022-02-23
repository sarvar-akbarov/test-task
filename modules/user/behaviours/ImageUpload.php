<?php

namespace app\modules\user\behaviours;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageUpload extends Behavior
{
    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $path;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'saveImage',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteImage',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveImage'
        ];
    }

    private function _setPath()
    {
        $this->path = \Yii::getAlias('@uploads') . '/' . $this->path . '/' . $this->owner->id . '/';
    }

    public function saveImage()
    {
        $this->image = $this->owner->{$this->attribute};
        $this->_setPath();
        if($this->image != null && $this->image instanceof UploadedFile){
            
            $old_image = $this->path . $this->owner->image;
            
            if(file_exists($old_image)){
                unlink($old_image);
            }

            if(!is_dir($this->path)){
                mkdir($this->path);
            }
            $this->image->saveAs($this->path . '/' . $this->image->basename . '.' . $this->image->extension);
        }
    }

    public function deleteImage()
    {
        $this->_setPath();

        if(is_dir($this->path)){
            FileHelper::removeDirectory($this->path);
        }
    }
}