<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 17:24
 */

namespace site\frontend\modules\photo\components\thumbs\filters;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;

class StaticFilter implements FilterInterface
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