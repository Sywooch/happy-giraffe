<?php
/**
 * Форма загрузки с компьютера
 *
 * Конкретная реализация форма для загрузки изображения с компьютера
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\models\upload;

class FromComputerUploadForm extends UploadForm
{
    /**
     * @var \CUploadedFile загруженный файл
     */
    public $file;

    public function attributeLabels()
    {
        return \CMap::mergeArray(parent::attributeLabels(), array(
            'file' => 'Файл изображения',
        ));
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('file', 'file', 'maxSize' => 1024 * 1024 * 8, 'tooLarge' => 'Файл больше 8мб'),
        ));
    }

    protected function getImageString()
    {
        return file_get_contents($this->file->getTempName());
    }

    protected function getOriginalName()
    {
        return $this->file->getName();
    }
} 