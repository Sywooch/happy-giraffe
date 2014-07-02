<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 12:21
 */

namespace site\frontend\modules\photo\components\thumbs\presets;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;

class LepillaPreset extends Preset implements PresetInterface
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
        $imageSize = $image->getSize();
        $imageWidth = $imageSize->getWidth();
        $imageHeight = $imageSize->getHeight();
        $imageRatio = $imageWidth / $imageHeight;
        $presetRatio = $this->width / $this->height;
        $newWidth = $imageRatio * $this->height;

        $image->resize(new Box($newWidth, $this->height));
        if ($imageRatio >= $presetRatio) {
            $start = new Point(($newWidth - $this->width) / 2, 0);
            $image->crop($start, new Box($this->width, $this->height));
        }
    }

    public function getWidth($imageWidth, $imageHeight)
    {
        $imageRatio = $imageWidth / $imageHeight;
        $presetRatio = $this->width / $this->height;
        if ($imageRatio >= $presetRatio) {
            return $this->width;
        } else {
            return $imageRatio * $this->height;
        }
    }

    public function getHeight($imageWidth, $imageHeight)
    {
        return $this->height;
    }
} 