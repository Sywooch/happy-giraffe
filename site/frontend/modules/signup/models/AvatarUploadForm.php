<?php
/**
 * Форма загрузки изображения для аватара
 *
 * Реализует валидацию и непосредственно сохраняет изображение на сервере, саму аватару не создает
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

    /**
     * Сохранение на сервер
     * @return mixed
     */
    public function upload()
    {
        $path = Yii::getPathOfAlias('site.common.uploads.photos.temp');
        if (! is_dir($path))
            mkdir($path);
        $this->fileName = sha1($this->image->getName() . time()) . '.' . $this->image->getExtensionName();
        return $this->image->saveAs($path . DIRECTORY_SEPARATOR . $this->fileName);
    }

    /**
     * Возвращает имя в файловой системе
     * @return string
     */
    public function getFileName()
    {
        return Yii::app()->params['photos_url'] . '/temp/' . $this->fileName;
    }
}