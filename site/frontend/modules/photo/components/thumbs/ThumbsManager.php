<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 15:52
 */

namespace site\frontend\modules\photo\components\thumbs;


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

    public function saveThumb($photo, $preset)
    {
        if (! array_key_exists($preset, $this->presets)) {
            throw new \CException('Неизвестное имя пресета');
        }

        $config = $this->presets[$preset];
        $className = $config[0] . 'Preset';
        $params = array_slice($config, 1);
        $reflect  = new \ReflectionClass($className);
        $preset = $reflect->newInstanceArgs($params);

        $image = $this->imagine->load(\Yii::app()->getModule('photo')->fs->read('originals/' . $photo->fs_name));
    }

    protected function getPath($photo, $preset)
    {

    }
} 