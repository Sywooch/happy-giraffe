<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 15:52
 */

namespace site\frontend\modules\photo\components\thumbs;


use Imagine\Imagick\Imagine;
use site\frontend\modules\photo\components\thumbs\presets\PresetInterface;
use site\frontend\modules\photo\models\Photo;

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

    public function createAll(Photo $photo)
    {
        foreach ($this->presets as $presetName) {
            $this->createThumb($photo, $presetName);
        }
    }

    public function createThumb(Photo $photo, $presetName)
    {
        $thumb = $this->getThumb($photo, $presetName);
        $image = $this->imagine->load(\Yii::app()->getModule('photo')->fs->read($photo->getOriginalFsPath()));
        $thumb->preset->apply($image);
        \Yii::app()->getModule('photo')->fs->write($thumb->getFsPath(), $image->get('gif'));
        return $thumb;
    }

    public function getThumb(Photo $photo, $presetName)
    {
        $preset = $this->createPreset($presetName);
        return new Thumb($photo, $preset);
    }

    protected function createPreset($presetName)
    {
        if (! array_key_exists($presetName, $this->presets)) {
            throw new \CException('Неизвестное имя пресета');
        }

        $config = $this->presets[$presetName];
        $className = '\site\frontend\modules\photo\components\thumbs\presets\\' . ucfirst($config[0]) . 'Preset';
        $params = array_slice($config, 1);
        $reflect  = new \ReflectionClass($className);
        $preset = $reflect->newInstanceArgs($params);
        $preset->name = $presetName;
        return $preset;
    }
} 