<?php
/**
 * Фильтр ресайза
 *
 * Соответствует оригинальному, просто реализует кастомный интерфейс.
 *
 * @author Никита
 * @date 03/10/14
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