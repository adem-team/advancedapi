<?php 

namespace api\modules\master\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class Barangumumupload extends Model
{
    /**
     * @var UploadedFile
     */
    public $IMAGE;

    public function rules()
    {
        return [
            [['IMAGE'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->IMAGE->saveAs('upload/' . $this->IMAGE->baseName . '.' . $this->IMAGE->extension);
            return true;
        } else {
            return false;
        }
    }
}