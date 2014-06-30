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

class UploadPreview implements FilterInterface
{
    /**
     * @var BoxInterface
     */
    public $size;
    
    public function __construct(BoxInterface $size)
    {
        $this->size = $size;
    }
    
    public function apply(ImageInterface $image)
    {
        $size = $image->getSize();
        $fromRatio = $size->getWidth() / $size->getHeight();
        $toRatio = $this->size->getWidth() / $this->size->getHeight();
        $image->resize(new Box($size->getWidth() * $fromRatio, $this->size->getHeight()));
        if ($fromRatio >= $toRatio) {
            $start = new Point(0, ($size->getWidth() * $fromRatio - $this->size->getHeight()) / 2);
            $image->crop($start, new Box($this->size->getWidth(), $this->size->getHeight()));
        }
    }
} 