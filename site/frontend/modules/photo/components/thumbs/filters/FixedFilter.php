<?php
/**
 * @author Никита
 * @date 31/10/14
 */

namespace site\frontend\modules\photo\components\thumbs\filters;


use Imagine\Filter\Basic\Thumbnail;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use site\frontend\modules\photo\components\thumbs\filters\CustomFilterInterface;

class FixedFilter implements  CustomFilterInterface
{
    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function apply(ImageInterface $image)
    {
        $image = $image->thumbnail(new Box($this->width, $this->height), ImageInterface::THUMBNAIL_OUTBOUND);
        return $image;
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