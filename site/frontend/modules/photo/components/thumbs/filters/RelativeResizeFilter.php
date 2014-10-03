<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/07/14
 * Time: 13:39
 */

namespace site\frontend\modules\photo\components\thumbs\filters;


use Imagine\Filter\Advanced\RelativeResize;

class RelativeResizeFilter extends RelativeResize implements CustomFilterInterface
{
    public function getWidth($imageWidth, $imageHeight)
    {
        return 100;
    }

    public function getHeight($imageWidth, $imageHeight)
    {
        return 100;
    }
} 