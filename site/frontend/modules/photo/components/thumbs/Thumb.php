<?php
/**
 * Миниатюра
 *
 * Приложение работает с миниатюрами именно через этот класс, сами миниатюры генерируются с помощью ThumbsManager
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\components\imageProcessor\ImageDecorator;
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

    public $format;

    public $imageDecorator;

    public function __construct($photo, $filter, $path, $animated)
    {
        $this->photo = $photo;
        $this->filter = $filter;
        $image = \Yii::app()->imagine->load(\Yii::app()->fs->read($this->path));
        $format = pathinfo($this->fs_name, PATHINFO_EXTENSION);
        $this->imageDecorator = new ImageDecorator($image, $filter, $format, $animated);

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

    public function get()
    {
        return $this->imageDecorator->get();
    }

    public function show()
    {
        return $this->imageDecorator->show();
    }

    public function save()
    {
        return $this->imageDecorator->save($this->path);
    }
} 