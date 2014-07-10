<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 10/07/14
 * Time: 15:25
 */

namespace site\frontend\modules\photo\components\thumbs;


class ThumbJPG extends Thumb
{
    protected function getOptions()
    {
        return \CMap::mergeArray(parent::getOptions(), array(
            'jpeg_quality' => $this->getJpegQuality(),
        ));
    }

    /**
     * Подсчитать качество JPEG для изображения
     *
     * Зависит от ширины изображения, настройки задаются в конфигурации компонента
     *
     * @return int качество JPEG
     */
    protected function getJpegQuality()
    {
        $width = $this->image->getSize()->getWidth();
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