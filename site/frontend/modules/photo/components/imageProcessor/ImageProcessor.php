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
    public function process($originalPath, $filter, $animate)
    {
        /** @var \Imagine\Imagick\Image $image */
        $image = \Yii::app()->imagine->load(\Yii::app()->fs->read($originalPath));
        $format = pathinfo($originalPath, PATHINFO_EXTENSION);
        $processor = $this->getProcessor($format, $animate);

        return $processor->process($image);
    }

    protected function getProcessor($format, $animate)
    {
        switch ($format) {
            case 'jpg':
                $class = 'JpgProcessor';
                break;
            case 'gif':
                if ($animate) {
                    $class = 'AnimatedGifProcessor';
                } else {
                    $class = 'StaticGifProcessor';
                }
                break;
            default:
                $class = 'Processor';
        }
        return $class;
    }
} 