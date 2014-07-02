<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 16:01
 */

namespace site\frontend\modules\photo\components\thumbs;


use Imagine\Imagick\Imagine;
use site\frontend\modules\photo\components\thumbs\presets\Preset;
use site\frontend\modules\photo\components\thumbs\presets\PresetInterface;
use site\frontend\modules\photo\models\Photo;

class Thumb extends \CComponent
{
    public $photo;
    public $preset;
    protected $imagine;

    public function __construct(Photo $photo, PresetInterface $preset)
    {
        $this->photo = $photo;
        $this->preset = $preset;
        $this->imagine = new Imagine();
    }

    public function getWidth()
    {
        return $this->preset->getWidth($this->photo->width, $this->photo->height);
    }

    public function getHeight()
    {
        return $this->preset->getHeight($this->photo->width, $this->photo->height);
    }

    public function getUrl()
    {
        return \Yii::app()->getModule('photo')->fs->getUrl($this->getFsPath($this->photo, $this->preset->name));
    }

    protected function getFsPath()
    {
        return 'thumbs/' . $this->preset->name . '/' . $this->photo->fs_name;
    }

    public function save()
    {
        $image = $this->imagine->load(\Yii::app()->getModule('photo')->fs->read($this->photo->getOriginalFsPath()));
        $this->preset->apply($image);
        \Yii::app()->getModule('photo')->fs->write($this->getFsPath($this->photo, $this->preset->name), $image->get('jpg'));
        return $this;
    }
} 