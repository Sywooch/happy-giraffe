<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 15:38
 */

namespace site\frontend\modules\photo\components;


use Imagine\Filter\Transformation;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Imagick\Imagine;

class ThumbsManager extends \CApplicationComponent
{
    public $presets;

    /**
     * @var Imagine
     */
    protected $imagine;

    public function init()
    {
        parent::init();
        $this->imagine = new Imagine();
    }

    public function thumbnail($path, $preset)
    {
        $blobImage = \Yii::app()->getModule('photo')->fs->read($path);
        $image = $this->imagine->load($blobImage);

    }
} 