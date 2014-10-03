<?php
/**
 * Кастомный фильтр
 *
 * Расширяет стандартный фильтр функциями подсчета размера итогового изображения без обработки как таковой.
 *
 * @author Никита
 * @date 03/10/14
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