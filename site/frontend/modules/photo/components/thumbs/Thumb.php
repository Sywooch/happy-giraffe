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
    public $preset;

    /**
     * @var
     */
    public $format;

    /**
     * @var \Imagine\Imagick\Image
     */
    protected $image;

    /**
     * Ширина миниатюры
     * @return int
     */
    public function getWidth()
    {
        return $this->preset->getWidth($this->photo->width, $this->photo->height);
    }

    /**
     * Высота миниатюры
     * @return int
     */
    public function getHeight()
    {
        return $this->preset->getHeight($this->photo->width, $this->photo->height);
    }

    /**
     * URL Миниатюры
     * @return string
     */
    public function getUrl()
    {
        return \Yii::app()->fs->getUrl($this->getFsPath($this->photo, $this->preset->name));
    }

    /**
     * Путь к миниатюре в файловой системе
     * @return string
     */
    public function getFsPath()
    {
        return 'thumbs/' . $this->preset->name . '/' . $this->photo->fs_name;
    }


    /**
     * Отобразить миниатюру
     */
    public function show()
    {
        $this->process();
        $this->image->show($this->format, $this->getOptions());
    }

    /**
     * Сгенерировать миниатюру фото по заданному имени пресета
     */
    public function save()
    {
        $this->process();
        \Yii::app()->fs->write($this->getFsPath(), $this->image->get($this->format, $this->getOptions()), true);
    }

    /**
     * Загрузить и обработать фото
     */
    protected function process()
    {
        $this->image = \Yii::app()->imagine->load(\Yii::app()->fs->read($this->photo->getOriginalFsPath()));
        $this->processImage();
    }

    /**
     * Обработать фото для получения нужной миниатюры
     */
    protected function processImage()
    {
        $this->preset->apply($this->image);
    }

    /**
     * @return array опции для Imagine
     */
    protected function getOptions()
    {
        return array();
    }
} 