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

class ThumbnailFilter implements CustomFilterInterface
{
    protected $width;
    protected $height;
    protected $mode;

    public function __construct($width, $height, $mode = ImageInterface::THUMBNAIL_OUTBOUND)
    {
        $this->width = $width;
        $this->height = $height;
        $this->mode = $mode;
    }

    public function apply(ImageInterface $image)
    {
        $image = $image->thumbnail(new Box($this->width, $this->height), $this->mode);
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