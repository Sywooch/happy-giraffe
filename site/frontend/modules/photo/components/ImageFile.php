<?php
/**
 * Файл изображения
 *
 * Инкапсулирует действия с ФС
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
     * @var Photo
     */
    protected $photo;

    public function __construct(Photo $photo)
    {
        $this->photo = $photo;
    }

    public function read()
    {
        return $this->buffer !== null ? $this->buffer : \Yii::app()->fs->read($this->getOriginalFsPath());
    }

    public function write()
    {
        return \Yii::app()->fs->write($this->getOriginalFsPath(), $this->photo->image);
    }

    public function getOriginalUrl()
    {
        return \Yii::app()->fs->getUrl($this->getOriginalFsPath());
    }

    protected function getOriginalFsPath()
    {
        return 'originals/' . $this->photo->fs_name;
    }
} 