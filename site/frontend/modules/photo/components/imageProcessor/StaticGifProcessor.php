<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 14:35
 */

namespace site\frontend\modules\photo\components\imageProcessor;


use Imagine\Imagick\Image;

class StaticGifProcessor extends Processor
{
    protected function getOptions(Image $image)
    {
        return \CMap::mergeArray(parent::getOptions($image), array(
            'animated' => false,
        ));
    }

    protected function processInternal(Image $image)
    {
        $layers = $image->layers();
        $count = count($layers);
        for ($i = 1; $i < $count; $i++) {
            $layers->remove($i);
        }
    }
} 