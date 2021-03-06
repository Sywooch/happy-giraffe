<?php
/**
 * Фильтр для анимированных GIF
 *
 * В библиотеке Imagination для того, чтобы корректно обработать анимированное изображение, необходимо явно
 * обработать каждый кадр. Данный фильтр - это обертка, выполняющая эту функцию.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs\filters\core;
use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
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
        foreach($layers AS $layer) {
            $this->filter->apply($layer);
        }        
        return $image;
    }
} 
