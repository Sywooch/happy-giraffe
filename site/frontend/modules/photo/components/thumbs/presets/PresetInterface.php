<?php
/**
 * Интерфейс пресета
 */

namespace site\frontend\modules\photo\components\thumbs\presets;
use Imagine\Image\ImageInterface;

interface PresetInterface
{
    /**
     * Применить пресет к изображению
     * @param ImageInterface $image
     */
    function apply(ImageInterface $image);

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