<?php
/**
 * Форма загрузки с компьютера
 *
 * Конкретная реализация форма для загрузки изображения с компьютера
 */

namespace site\frontend\modules\photo\models\upload;
use site\frontend\modules\photo\models\PhotoCreate;

class FromComputerUploadForm extends UploadForm
{
    /**
     * @var \CUploadedFile загруженный файл
     */
    public $file;

    public function attributeLabels()
    {
        return \CMap::mergeArray(parent::attributeLabels(), array(
            'file' => 'Файлы изображений',
        ));
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('file', 'file', 'maxSize' => 1024 * 1024 * 8),
        ));
    }

    public function __construct()
    {
        $this->file = \CUploadedFile::getInstanceByName('image');
    }

    public function populate()
    {
        return new PhotoCreate($this->file->getTempName(), $this->file->getName());
    }
} 