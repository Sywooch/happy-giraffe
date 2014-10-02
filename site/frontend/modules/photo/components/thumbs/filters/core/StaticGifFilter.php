<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 14:35
 */

namespace site\frontend\modules\photo\components\thumbs\filters\core;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Image;

class StaticGifFilter implements FilterInterface
{
    public function apply(ImageInterface $image)
    {
        $layers = $image->layers();
        $layers->coalesce();
        return $layers->offsetGet(0);
    }
} 