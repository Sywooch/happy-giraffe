<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/09/14
 * Time: 14:19
 */

namespace site\frontend\modules\photo\components\imageProcessor;


use Imagine\Imagick\Image;
use site\frontend\modules\photo\components\thumbs\filters\CustomFilterInterface;

class Processor
{
    protected $filter;

    public function __construct(CustomFilterInterface $filter)
    {
        $this->filter = $filter;
    }

    public function process(Image $image)
    {
        $this->processInternal($image);
        return $image;
    }

    protected function getOptions(Image $image)
    {
        return array();
    }

    protected function processInternal(Image $image)
    {
        $this->filter->apply($image);
    }
} 