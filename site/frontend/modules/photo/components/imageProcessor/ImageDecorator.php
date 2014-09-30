<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/09/14
 * Time: 12:40
 */

namespace site\frontend\modules\photo\components\imageProcessor;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Image;

class ImageDecorator
{
    protected $image;
    protected $filter;
    protected $format;
    protected $animated;
    protected $options;

    public function __construct(ImageInterface $image, FilterInterface $filter, $format, $animated)
    {
        $this->format = $format;
        $this->image = $image;
        $this->animated = $animated;
        $this->filter = $filter;

        $this->options['animated'] = $animated;
        switch ($this->format) {
            case 'gif':
            case 'png':
                if ($this->animated) {
                    $_filter = new AnimatedGifFilter($filter);
                } else {
                    $_filter = new StaticGifFilter();
                }
                $_filter->apply($this->image);
            case 'jpg':
                $this->options['jpeg_quality'] = $this->getJpegQuality();
                break;
            default:
                throw new \CException('Неподдерживаемый формат');
        }
    }

    public function get()
    {
        return $this->image->get($this->format, $this->options);
    }

    public function show()
    {
        return $this->image->show($this->format, $this->options);
    }

    public function save($path)
    {
        return $this->image->save($path, $this->options);
    }

    protected function getJpegQuality()
    {
        $width = $this->filter->getWidth($this->image->getSize()->getWidth(), $this->image->getSize()->getHeight());
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