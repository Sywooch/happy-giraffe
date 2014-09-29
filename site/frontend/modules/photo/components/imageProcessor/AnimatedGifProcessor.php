<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 14:37
 */

namespace site\frontend\modules\photo\components\imageProcessor;


use Imagine\Imagick\Image;

class AnimatedGifProcessor extends Processor
{
    protected function getOptions(Image $image)
    {
        return \CMap::mergeArray(parent::getOptions($image), array(
            'animated' => true,
        ));
    }

    protected function processInternal(Image $image)
    {
        foreach ($image->layers() as $frame) {
            $this->filter->apply($frame);
        }
    }
} 