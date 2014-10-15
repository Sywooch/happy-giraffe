<?php
/**
 * Компонент для работы с обычными миниатюрами
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\models\Photo;

class SimpleThumbsManager extends ThumbsManager
{
    /**
     * @var array конфигурация пресетов
     */
    public $presets;

    /**
     * Получить миниатюру фото по заданному имени пресета
     * @param Photo $photo
     * @param $presetName
     * @param bool $replace
     * @return Thumb
     * @throws \CException
     */
    public function getThumb(Photo $photo, $presetName, $replace = false)
    {
        $filter = $this->createFilter($presetName);
        $path = $this->getFsPath($photo, $presetName);
        return $this->getThumbInternal($photo, $filter, $path, true, $replace);
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
     * Инициализирует класс пресета
     * @param $presetName
     * @return filters\CustomFilterInterface
     * @throws \CException
     */
    protected function createFilter($presetName)
    {
        if (! array_key_exists($presetName, $this->presets)) {
            throw new \CException('Неизвестное имя пресета');
        }

        $config = $this->presets[$presetName];
        $className = '\site\frontend\modules\photo\components\thumbs\filters\\' . ucfirst($config['filter']) . 'Filter';
        $params = array_slice($config, 1);
        $reflect  = new \ReflectionClass($className);
        $filter = $reflect->newInstanceArgs($params);
        $filter->name = $presetName;
        return $filter;
    }

    protected function getFsPath(Photo $photo, $presetName)
    {
        return 'thumbs/' . $presetName . '/' . $photo->fs_name;
    }
} 