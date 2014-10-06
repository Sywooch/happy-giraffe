<?php
/**
 * Статический фильтр для анимированных GIF
 *
 * Если обрабатываем статический гиф, необходимо убрать все кадры, кроме первого - иначе в итоговом изображении
 * будут изображены все кадры поверх друг друга.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs\filters\core;
use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;

class StaticGifFilter implements FilterInterface
{
    public function apply(ImageInterface $image)
    {
        $layers = $image->layers();
        $layers->coalesce();
        return $layers->offsetGet(0);
    }
} 