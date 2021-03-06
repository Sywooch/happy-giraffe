<?php
/**
 * Надстройка над Imagine
 *
 * Добавляет логику к стандартной обработке фото - управляет анимацией, определяет качество.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs;
use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use site\frontend\modules\photo\components\thumbs\filters\core\AnimatedGifFilter;
use site\frontend\modules\photo\components\thumbs\filters\core\StaticGifFilter;
use site\frontend\modules\photo\components\thumbs\filters\CustomFilterInterface;
use site\frontend\modules\photo\helpers\ImageSizeHelper;

class ImageDecorator
{
    /**
     * @var ImageInterface
     */
    public $image;

    /**
     * @var string
     */
    protected $inputFormat;

    /**
     * @var string
     */
    protected $outputFormat;

    /**
     * @var bool
     */
    protected $animated;

    /**
     * @var array
     */
    protected $options;

    public function __construct($imageString, $animated)
    {
        $this->image = \Yii::app()->imagine->load($imageString);
        $imageSize = ImageSizeHelper::getImageSize($imageString);
        $this->inputFormat = \Yii::app()->getModule('photo')->types[$imageSize[2]];
        $this->animated = $animated && $this->inputFormat == 'gif';
        $this->outputFormat = $this->animated ? 'gif' : 'jpg';
        $this->prepare();
    }

    public function get()
    {
        return $this->image->get($this->outputFormat, $this->options);
    }

    public function show()
    {
        return $this->image->show($this->outputFormat, $this->options);
    }

    public function applyFilter(CustomFilterInterface $filter)
    {
        $filters = array();

        if ($this->inputFormat == 'gif') {
            if ($this->animated) {
                $filters[] = new AnimatedGifFilter($filter);
            } else {
                $filters[] = new StaticGifFilter();
                $filters[] = $filter;
            }
        } else {
            $filters[] = $filter;
        }

        foreach ($filters as $f) {
            $this->image = $f->apply($this->image);
        }
    }

    public function __call($method, $arguments = array())
    {
        return call_user_func_array(array($this->image, $method), $arguments);

    }

    protected function prepare()
    {
        $this->image->strip();
        $this->options['animated'] = $this->animated;
        if ($this->outputFormat == 'jpg') {
            $this->options['jpeg_quality'] = $this->getJpegQuality();
        }
    }

    protected function getJpegQuality()
    {
        $width = $this->image->getSize()->getWidth();
        $config = \Yii::app()->getModule('photo')->quality;
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