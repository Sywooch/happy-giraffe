<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 17:26
 */

namespace site\frontend\modules\photo\components\thumbs\filters;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;

class AnimatedFilter implements FilterInterface
{
    public $filter;

    public function apply(ImageInterface $image)
    {
        foreach ($image->layers() as $frame) {
            $this->filter->apply($frame);
        }
    }
} 