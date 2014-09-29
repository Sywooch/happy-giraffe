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
} 