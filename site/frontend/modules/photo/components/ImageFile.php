<?php
/**
 * Файл изображения.
 *
 * Инкапсулирует действия с ФС.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components;
use site\frontend\modules\photo\models\Photo;

class ImageFile extends \CComponent
{
    /**
     * @var string
     */
    public $buffer;

    /**
     * @var Photo модель фото
     */
    protected $photo;

    /**
     * @param \site\frontend\modules\photo\models\Photo $photo модель фото
     */
    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }

    /**
     * Считывает файл из ФС.
     *
     * @return string
     */
    public function read()
    {
        return $this->buffer !== null ? $this->buffer : \Yii::app()->fs->read($this->getOriginalFsPath());
    }

    /**
     * Записывает файл изображения в ФС.
     *
     * @return boolean
     */
    public function write()
    {
        return \Yii::app()->fs->write($this->getOriginalFsPath(), $this->photo->image) > 0;
    }

    /**
     * Возвращает URL файла
     *
     * @return string URL файла
     */
    public function getOriginalUrl()
    {
        return \Yii::app()->fs->getUrl($this->getOriginalFsPath());
    }

    /**
     * Возвращает путь файла в ФС.
     *
     * @return string путь файла в ФС
     */
    protected function getOriginalFsPath()
    {
        return 'originals/' . $this->photo->fs_name;
    }
} 