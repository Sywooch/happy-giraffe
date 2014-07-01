<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 17:46
 */

namespace site\frontend\modules\photo\components\filters;


use Imagine\Filter\FilterInterface;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

class Lepilla implements FilterInterface
{
    public $width;
    public $height;

    protected $size;
    
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }
    
    public function apply(ImageInterface $image)
    {
        $size = $image->getSize();
        $fromRatio = $size->getWidth() / $size->getHeight();
        $toRatio = $this->width / $this->height;
        $image->resize(new Box($size->getWidth() * $fromRatio, $this->height));
        if ($fromRatio >= $toRatio) {
            $start = new Point(0, ($size->getWidth() * $fromRatio - $this->height) / 2);
            $image->crop($start, new Box($this->width, $this->height));
        }
    }
} 