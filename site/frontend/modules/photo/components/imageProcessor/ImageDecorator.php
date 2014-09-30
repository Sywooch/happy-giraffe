<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/09/14
 * Time: 12:40
 */

namespace site\frontend\modules\photo\components\imageProcessor;


use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Image;

class ImageDecorator
{
    protected $image;
    protected $format;
    protected $animated;

    public function __construct(ImageInterface $image, FilterInterface $filter, $format, $animated)
    {
        $this->format = $format;
        $this->image = $image;
        $this->animated = $animated;
        switch ($this->format) {
            case 'gif':
            case 'png':
            if ($this->animated) {
                $_filter = new AnimatedGifProcessor($filter);
            } else {
                $_filter = new StaticGifProcessor();
            }
            $_filter->apply($this->image);
        }
    }

    public function get()
    {
        return $this->image->get($this->format);
    }

    public function show()
    {
        return $this->image->show($this->format);
    }

    public function save($path)
    {
        return $this->image->save($path);
    }

    protected function getOptions()
    {
        if ($this->)
    }
} 