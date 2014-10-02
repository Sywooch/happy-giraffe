<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/09/14
 * Time: 12:40
 */

namespace site\frontend\modules\photo\components\thumbs;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Image;
use site\frontend\modules\photo\components\thumbs\filters\core\AnimatedGifFilter;
use site\frontend\modules\photo\components\thumbs\filters\core\StaticGifFilter;

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
        $this->animated = $animated && $format == 'gif';
        $this->filter = $filter;
        $this->prepare();
    }

    public function get()
    {
        return $this->image->get($this->format, $this->options);
    }

    public function show()
    {
        return $this->image->show($this->format, $this->options);
    }

    protected function prepare()
    {
        $this->options['animated'] = $this->animated;
        $filters = array();
        switch ($this->format) {
            case 'gif':
                if ($this->animated) {
                    $filters[] = new AnimatedGifFilter($this->filter);
                } else {
                    $filters[] = new StaticGifFilter();
                    $filters[] = $this->filter;
                }
                break;
            case 'jpg':
            case 'png':
                $filters[] = $this->filter;
                $this->options['jpeg_quality'] = $this->getJpegQuality();
                break;
            default:
                throw new \CException('Неподдерживаемый формат');
        }

//        var_dump($filters);
//        die;

        foreach ($filters as $f) {
            $this->image = $f->apply($this->image);
        }
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