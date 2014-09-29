<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 14:28
 */

namespace site\frontend\modules\photo\components\imageProcessor;


use Imagine\Imagick\Image;

class JpgProcessor extends Processor
{
    protected function getOptions(Image $image)
    {
        return \CMap::mergeArray(parent::getOptions($image), array(
            'jpeg_quality' => $this->getJpegQuality($image),
        ));
    }

    /**
     * Подсчитать качество JPEG для изображения
     *
     * Зависит от ширины изображения, настройки задаются в конфигурации компонента
     *
     * @return int качество JPEG
     */
    protected function getJpegQuality(\Imagine\Imagick\Image $image)
    {
        $width = $this->filter->getWidth($image->getSize()->getWidth(), $image->getSize()->getHeight());
        $config = \Yii::app()->thumbs->quality;
        $q = array_pop($config);
        $config = array_reverse($config, true);
        foreach ($config as $minWidth => $quality) {
            if ($width <= $minWidth) {
                $q = $quality;
            } else {
                break;
            }
        }
        return $q;
    }
} 