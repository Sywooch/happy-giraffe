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

    public function init()
    {
        parent::init();
    }

    /**
     * Создать миниатюры всех доступных пресетов для переданного фото
     * @param Photo $photo
     */
    public function createAll(Photo $photo)
    {
        foreach ($this->presets as $presetName => $config) {
            $this->getThumb($photo, $presetName, true);
        }
    }

    /**
     * Получить миниатюру фото по заданному имени пресета
     * @param Photo $photo
     * @param string $presetName
     * @param bool $create
     * @return Thumb
     */
    public function getThumb(Photo $photo, $presetName, $create = false)
    {
        $preset = $this->createPreset($presetName);
        $thumb = new Thumb($photo, $preset);
        if ($create) {
            $thumb->save();
        }
        return $thumb;
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