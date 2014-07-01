<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 15:52
 */

namespace site\frontend\modules\photo\components\thumbs;


use Imagine\Imagick\Imagine;
use site\frontend\modules\photo\components\thumbs\presets\Preset;
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

    public function saveThumb(Photo $photo, $presetName)
    {
        $preset = $this->createPreset($presetName);

        $image = $this->imagine->load(\Yii::app()->getModule('photo')->fs->read('originals/' . $photo->fs_name));



        $preset->apply($image);

        \Yii::app()->getModule('photo')->fs->write('thumbs/' . $presetName . '/' . $photo->fs_name, $image->get('jpg'));
    }

    public function getThumb($photo, $presetName)
    {
        $preset = $this->createPreset($presetName);

        return new Thumb($photo, $preset);
    }

    protected function getPath($photo, $preset)
    {

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
        return $reflect->newInstanceArgs($params);
    }
} 