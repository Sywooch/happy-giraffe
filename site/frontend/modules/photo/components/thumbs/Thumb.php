<?php
/**
 * Миниатюра
 *
 * Приложение работает с миниатюрами именно через этот класс, сами миниатюры генерируются с помощью ThumbsManager
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\components\thumbs\presets\PresetInterface;
use site\frontend\modules\photo\models\Photo;

class Thumb extends \CComponent
{
    /**
     * @var \site\frontend\modules\photo\models\Photo модель фотографии
     */
    public $photo;

    /**
     * @var filters\CustomFilterInterface|filters\Filter используемый для создания миниатюры пресет
     */
    public $filter;

    /**
     * @var
     */
    public $path;

    public function __construct($photo, $filter, $path)
    {
        $this->photo = $photo;
        $this->filter = $filter;
        $this->path = $path;
    }

    /**
     * Ширина миниатюры
     * @return int
     */
    public function getWidth()
    {
        return $this->filter->getWidth($this->photo->width, $this->photo->height);
    }

    /**
     * Высота миниатюры
     * @return int
     */
    public function getHeight()
    {
        return $this->filter->getHeight($this->photo->width, $this->photo->height);
    }

    /**
     * URL Миниатюры
     * @return string
     */
    public function getUrl()
    {
        return \Yii::app()->fs->getUrl($this->path);
    }

    public function getImage()
    {
        $image = \Yii::app()->imagine->load(\Yii::app()->fs->read($this->path));
        $image = \Yii::app()->imageProcessor->process($image, $this->filter, true);
        return $image;
    }
} 