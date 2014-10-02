<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/10/14
 * Time: 12:19
 */

namespace site\frontend\modules\photo\components;


class ImageFile extends \CComponent
{
    protected $photo;
    public $buffer;

    public function __construct($photo)
    {
        $this->photo = $photo;
    }

    public function read()
    {
        return \Yii::app()->fs->read($this->getOriginalFsPath());
    }

    public function write($imageString = null)
    {
        if ($imageString === null) {
            $imageString = $this->buffer;
        }

        if ($imageString === null) {
            throw new \CException('Содержимое файла для записи не задано');
        }

        return \Yii::app()->fs->write($this->getOriginalFsPath(), $imageString);
    }

    public function getOriginalUrl()
    {
        return \Yii::app()->fs->getUrl($this->getOriginalFsPath());
    }

    public function getOriginalFsPath()
    {
        return 'originals/' . $this->photo->fs_name;
    }
} 