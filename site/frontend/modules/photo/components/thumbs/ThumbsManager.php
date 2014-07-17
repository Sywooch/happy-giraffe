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
    /**
     * @var array конфигурация пресетов
     */
    public $presets;

    /**
     * @var array конфигурация соответсвия ширины и качества JPEG
     */
    public $quality;

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
        $thumb = ThumbFactory::create($photo, $preset);
        if ($create) {
            $thumb->save();
        }
        return $thumb;
    }

    /**
     * Инициализирует класс пресета
     * @param $presetName
     * @return filters\CustomFilterInterface
     * @throws \CException
     */
    protected function createPreset($presetName)
    {
        if (! array_key_exists($presetName, $this->presets)) {
            throw new \CException('Неизвестное имя пресета');
        }

        $config = $this->presets[$presetName];
        $className = '\site\frontend\modules\photo\components\thumbs\presets\\' . ucfirst($config[0]) . 'Filter';
        $params = array_slice($config, 1);
        $reflect  = new \ReflectionClass($className);
        $preset = $reflect->newInstanceArgs($params);
        $preset->name = $presetName;
        return $preset;
    }
} 