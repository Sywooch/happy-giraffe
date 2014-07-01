<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 16:01
 */

namespace site\frontend\modules\photo\components\thumbs;


use site\frontend\modules\photo\components\thumbs\presets\Preset;
use site\frontend\modules\photo\models\Photo;

class Thumb extends \CComponent
{
    public $photo;
    public $preset;

    public function __construct(Photo $photo, Preset $preset)
    {
        $this->photo = $photo;
        $this->preset = $preset;
    }

    public function getWidth()
    {
        return $this->preset->getWidth($this->photo->width, $this->photo->height);
    }

    public function getHeight()
    {
        return $this->preset->getHeight($this->photo->width, $this->photo->height);
    }

    public function getSrc()
    {
        return \Yii::app()->getModule('photo')->fs->getUrl('thumbs/' . 'uploadMin' . '/' . $this->photo->fs_name);
    }
} 