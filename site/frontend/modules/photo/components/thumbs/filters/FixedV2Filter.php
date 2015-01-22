<?php
/**
 * @author Никита
 * @date 22/01/15
 */

namespace site\frontend\modules\photo\components\thumbs\filters;


use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

class FixedV2Filter implements CustomFilterInterface
{
    protected $width;
    protected $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function apply(ImageInterface $image)
    {
        $imageRatio = $image->getSize()->getWidth() / $image->getSize()->getHeight();
        $outputRatio = $this->width / $this->height;
        if ($imageRatio > $outputRatio) {
            $size = $image->getSize()->heighten($this->height);
        } else {
            $size = $image->getSize()->widen($this->width);
        }
        $image->resize($size);

        return $image->crop(new Point(($image->getSize()->getWidth() - $this->width) / 2, 0), new Box($this->width, $this->height));
    }

    public function getWidth($imageWidth, $imageHeight)
    {
        return $this->width;
    }

    public function getHeight($imageWidth, $imageHeight)
    {
        return $this->height;
    }
} 