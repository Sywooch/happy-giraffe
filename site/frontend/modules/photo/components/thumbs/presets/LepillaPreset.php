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

class LepillaPreset extends Preset
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
        $size = $image->getSize();
        $fromRatio = $size->getWidth() / $size->getHeight();
        $toRatio = $this->width / $this->height;
        $image->resize(new Box($size->getWidth() * $fromRatio, $this->height));
        if ($fromRatio >= $toRatio) {
            $start = new Point(0, ($size->getWidth() * $fromRatio - $this->height) / 2);
            $image->crop($start, new Box($this->width, $this->height));
        }
    }
} 