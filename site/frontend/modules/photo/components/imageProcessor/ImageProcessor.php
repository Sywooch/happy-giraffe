<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 13:29
 */

namespace site\frontend\modules\photo\components\imageProcessor;


class ImageProcessor extends \CApplicationComponent
{
    public $quality;

    public function process($image, $filter, $animate)
    {
        /** @var \Imagine\Imagick\Image $image */
//        $image = \Yii::app()->imagine->load(\Yii::app()->fs->read($originalPath));
//        $format = pathinfo($originalPath, PATHINFO_EXTENSION);
        $format = 'gif';
        $processor = $this->getProcessor($format, $animate, $filter);



        return $processor->process($image);
    }

    protected function getProcessor($format, $animate, $filter)
    {
        switch ($format) {
            case 'jpg':
                $class = 'site\frontend\modules\photo\components\imageProcessor\JpgProcessor';
                break;
            case 'gif':
                if ($animate) {
                    $class = 'site\frontend\modules\photo\components\imageProcessor\AnimatedGifProcessor';
                } else {
                    $class = 'site\frontend\modules\photo\components\imageProcessor\StaticGifProcessor';
                }
                break;
            default:
                $class = 'site\frontend\modules\photo\components\imageProcessor\Processor';
        }
        return new $class($filter);
    }

    public function get($image, $filter, $format, $animated)
    {
        $image = $this->prepare($image, $filter, $format, $animated);
        return $image->get($format);
    }

    public function save($image, $filter, $format, $animated)
    {
        $image = $this->prepare($image, $filter, $format, $animated);
        return $image->save($format);
    }

    public function show($image, $filter, $format, $animated)
    {
        $image = $this->prepare($image, $filter, $format, $animated);
        return $image->show($format);
    }

    protected function prepare($image, $filter, $format, $animated)
    {
        if ($format == 'gif') {
            if ($animated) {
                $_filter = new AnimatedGifProcessor($filter);
            } else {
                $_filter = new StaticGifProcessor();
            }
            $_filter->apply($image);
        }
        return $image;
    }

    protected function getJpegQuality(\Imagine\Imagick\Image $image)
    {
        $width = $this->filter->getWidth($image->getSize()->getWidth(), $image->getSize()->getHeight());
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