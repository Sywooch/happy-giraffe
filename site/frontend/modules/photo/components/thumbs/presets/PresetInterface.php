<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 12:18
 */

namespace site\frontend\modules\photo\components\thumbs\presets;
use Imagine\Image\ImageInterface;

interface PresetInterface
{
    function apply(ImageInterface $image);
    function getWidth($imageWidth, $imageHeight);
    function getHeight($imageWidth, $imageHeight);
} 