<?php
/**
 * Менеджер миниатюр
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

    /**
     * Создать миниатюры всех доступных пресетов для переданного фото
     * @param Photo $photo
     */
    public function createAll(Photo $photo)
    {
        foreach ($this->presets as $presetName => $config) {
            $this->createThumb($photo, $presetName);
        }
    }

    /**
     * Сгенерировать миниатюру фото по заданному имени пресета
     * @param Photo $photo
     * @param $presetName
     * @return Thumb
     */
    public function createThumb(Photo $photo, $presetName)
    {
        $thumb = $this->getThumb($photo, $presetName);
        $image = $this->imagine->load(\Yii::app()->fs->read($photo->getOriginalFsPath()));
        $thumb->preset->apply($image);
        \Yii::app()->fs->write($thumb->getFsPath(), $image->get('gif'), true);
        return $thumb;
    }

    /**
     * Получить миниатюру фото по заданному имени пресета
     * @param Photo $photo
     * @param $presetName
     * @return Thumb
     */
    public function getThumb(Photo $photo, $presetName)
    {
        $preset = $this->createPreset($presetName);
        return new Thumb($photo, $preset);
    }

    /**
     * Инициализирует класс пресета
     * @param $presetName
     * @return presets\PresetInterface
     * @throws \CException
     */
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