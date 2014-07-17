<?php
/**
 * Интерфейс пресета
 */

namespace site\frontend\modules\photo\components\thumbs\filters;
use Imagine\Filter\FilterInterface;

interface CustomFilterInterface extends FilterInterface
{
    /**
     * Подсчитать ширину полученного изображения
     * @param int $imageWidth
     * @param int $imageHeight
     * @return int
     */
    function getWidth($imageWidth, $imageHeight);

    /**
     * Подсчитать высоту полученного изображения
     * @param int $imageWidth
     * @param int $imageHeight
     * @return int mixed
     */
    function getHeight($imageWidth, $imageHeight);
} 