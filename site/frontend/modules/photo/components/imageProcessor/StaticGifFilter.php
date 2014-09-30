<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 14:35
 */

namespace site\frontend\modules\photo\components\imageProcessor;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Image;

class StaticGifFilter implements FilterInterface
{
    public function apply(ImageInterface $image)
    {
        $layers = $image->layers();
        $count = count($layers);
        for ($i = 1; $i < $count; $i++) {
            $layers->remove($i);
        }
    }
} 