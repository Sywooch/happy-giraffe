<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 10/07/14
 * Time: 15:25
 */

namespace site\frontend\modules\photo\components\thumbs;


class ThumbGIF extends Thumb
{
    protected function getOptions()
    {
        return \CMap::mergeArray(parent::getOptions(), array(
            'animated' => true,
        ));
    }

    protected function processImage()
    {
        $this->image->layers()->coalesce();
        foreach ($this->image->layers() as $frame) {
            $this->preset->apply($frame);
        }
    }
} 