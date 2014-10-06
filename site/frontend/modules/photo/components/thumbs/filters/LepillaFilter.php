<?php
/**
 * Пресет Lepilla, в честь Александра
 *
 * Независимо от изображения и конфигурации, происходит ресайз к заданной высоте. Если соотношение ширины к высоте
 * оригинального изображения превышает заданные конфигурацией пресета, то происходит вырезка фрагмента нужной ширины
 * из центра. В противном случае, изображение получается в ширину меньше, чем задано пресетом, но без обрезки.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs\filters;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;

class LepillaFilter implements CustomFilterInterface
{
    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function apply(ImageInterface $image)
    {
        $imageSize = $image->getSize();
        $imageWidth = $imageSize->getWidth();
        $imageHeight = $imageSize->getHeight();
        $imageRatio = $imageWidth / $imageHeight;
        $presetRatio = $this->width / $this->height;
        $newWidth = $imageRatio * $this->height;

        $image->resize(new Box($newWidth, $this->height));
        if ($imageRatio >= $presetRatio) {
            $start = new Point(($newWidth - $this->width) / 2, 0);
            $image->crop($start, new Box($this->width, $this->height));
        }
        return $image;
    }

    public function getWidth($imageWidth, $imageHeight)
    {
        $imageRatio = $imageWidth / $imageHeight;
        $presetRatio = $this->width / $this->height;
        if ($imageRatio >= $presetRatio) {
            return $this->width;
        } else {
            return $imageRatio * $this->height;
        }
    }

    public function getHeight($imageWidth, $imageHeight)
    {
        return $this->height;
    }
} 