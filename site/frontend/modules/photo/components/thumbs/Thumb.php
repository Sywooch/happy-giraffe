<?php
/**
 * Миниатюра
 *
 * Приложение работает с миниатюрами именно через этот класс, сами миниатюры генерируются с помощью ThumbsManager
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\components\thumbs\filters\CustomFilterInterface;
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
     * @var string
     */
    public $path;

    /**
     * @var bool
     */
    public $animated;

    public function __construct(Photo $photo, CustomFilterInterface $filter, $path, $animated)
    {
        $this->path = $path;
        $this->photo = $photo;
        $this->filter = $filter;
        $this->animated = $animated;
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
        return $this->getDecorator()->get();
    }

    public function show()
    {
        return $this->getDecorator()->show();
    }

    public function __toString()
    {
        return $this->getUrl();
    }

    protected function getDecorator()
    {
        $decorator = new ImageDecorator($this->photo->getImage(), $this->animated);
        $decorator->applyFilter($this->filter);
        return $decorator;
    }
} 