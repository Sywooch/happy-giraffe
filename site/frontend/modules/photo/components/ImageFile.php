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
    public $buffer;
    protected $photo;

    public function __construct($photo)
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