<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 14:37
 */

namespace site\frontend\modules\photo\components\thumbs\filters\core;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Image;

class AnimatedGifFilter implements FilterInterface
{
    protected $filter;

    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    public function apply(ImageInterface $image)
    {
        $layers = $image->layers();
        $layers->coalesce();
        foreach ($layers as $frame) {
            $this->filter->apply($frame);
        }
        return $image;
    }
} 