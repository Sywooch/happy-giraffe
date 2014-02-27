<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 27/02/14
 * Time: 12:40
 * To change this template use File | Settings | File Templates.
 */

class AvatarUploadForm extends CFormModel
{
    public $image;
    private $fileName;

    public function rules()
    {
        return array(
            array('image', 'file', 'types' => 'jpg, jpeg, gif, png'),
        );
    }

    public function upload()
    {
        $path = Yii::getPathOfAlias('site.common.uploads.photos.temp');
        if (! is_dir($path))
            mkdir($path);
        $this->fileName = sha1($this->image->getName() . time()) . '.' . $this->image->getExtensionName();
        return $this->image->saveAs($path . DIRECTORY_SEPARATOR . $this->fileName);
    }

    public function getFileName()
    {
        return Yii::app()->params['photos_url'] . '/temp/' . $this->fileName;
    }
}