<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 12:18
 */

namespace site\frontend\modules\photo\components\thumbs\presets;
use Imagine\Image\ImageInterface;

abstract class Preset extends \CComponent
{
    abstract function apply(ImageInterface $image);
} 