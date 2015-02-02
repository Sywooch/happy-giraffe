<?php
/**
 * @author Никита
 * @date 19/01/15
 */

namespace site\frontend\modules\photo\components\thumbs\filters;


use Imagine\Image\ImageInterface;

class WidenFilter implements CustomFilterInterface
{
    public $width;
    public $resizeUp;

    public function __construct($width, $resizeUp = false)
    {
        $this->width = $width;
        $this->resizeUp = $resizeUp;
    }

    public function apply(ImageInterface $image)
    {
        $outputWidth = $this->getOutputWidth($image->getSize()->getWidth());
        return $image->resize($image->getSize()->widen($outputWidth));
    }

    public function getWidth($imageWidth, $imageHeight)
    {
        return $this->getOutputWidth($imageWidth);
    }

    public function getHeight($imageWidth, $imageHeight)
    {
        $ratio = $imageWidth / $this->width;
        return $imageHeight * $ratio;
    }

    protected function getOutputWidth($imageWidth)
    {
        if ($this->resizeUp) {
            return $this->width;
        } else {
            return ($this->width > $imageWidth) ? $imageWidth : $this->width;
        }
    }
} 