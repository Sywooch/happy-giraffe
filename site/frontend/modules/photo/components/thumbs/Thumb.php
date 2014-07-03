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
     * @var presets\PresetInterface|presets\Preset используемый для создания миниатюры пресет
     */
    public $preset;

    /**
     * @var \Imagine\Imagick\Image
     */
    protected $image;


    public function __construct(Photo $photo, PresetInterface $preset)
    {
        $this->photo = $photo;
        $this->preset = $preset;
    }

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

    public function show()
    {
        if ($this->image === null) {
            $this->process();
        }
        $this->image->show($this->getFormat(), $this->getOptions());
    }

    /**
     * Сгенерировать миниатюру фото по заданному имени пресета
     */
    public function save()
    {
        $this->process();
        \Yii::app()->fs->write($this->getFsPath(), $this->image->get($this->getFormat(), $this->getOptions()), true);
    }

    protected function process()
    {
        $this->image = \Yii::app()->imagine->load(\Yii::app()->fs->read($this->photo->getOriginalFsPath()));
        $this->preset->apply($this->image);
    }

    protected function getFormat()
    {
        return pathinfo($this->photo->fs_name, PATHINFO_EXTENSION);
    }

    protected function getOptions()
    {
        $options = array();
        if ($this->getFormat() == 'jpg') {
            $options['jpeg_quality'] = $this->getJpegQuality();
        }
        return $options;
    }

    protected function getJpegQuality()
    {
        $width = $this->image->getSize()->getWidth();
        $config = \Yii::app()->thumbs->quality;
        $q = array_pop($config);
        $config = array_reverse($config, true);
        foreach ($config as $minWidth => $quality) {
            if ($width <= $minWidth) {
                $q = $quality;
            } else {
                break;
            }
        }
        return $q;
    }
} 